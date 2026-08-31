<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\UndanganCetak;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
use Throwable;

class UndanganCetakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = UndanganCetak::query()->with('jenisUndangan');

        // Pencarian berdasarkan nama
        if ($search = $request->query('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Filter berdasarkan jenis_id
        if ($jenis_id = $request->query('jenis_id')) {
            $query->where('jenis_id', $jenis_id);
        }

        // Filter favorite
        if ($request->has('favorite')) {
            $query->where('favorite', (bool) $request->query('favorite'));
        }

        // Filter promo (ada / tidak)
        if ($request->has('promo')) {
            $promo = $request->query('promo');
            if ($promo === '1' || $promo === 'true') {
                $query->where('promo', '>', 0);
            } elseif ($promo === '0' || $promo === 'false') {
                $query->where('promo', 0);
            }
        }

        // Urutkan
        $sortBy = $request->query('sort_by', 'id');
        $sortDir = $request->query('sort_dir', 'desc');
        $allowedSorts = ['id', 'nama', 'harga', 'promo', 'stok', 'terjual', 'favorite', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        // Pagination
        $perPage = min((int) $request->query('per_page', 15), 100);
        $data = $query->paginate($perPage);

        // Tambahkan thumbnail_url ke setiap item
        $data->getCollection()->transform(function ($item) {
            $item->append('thumbnail_url');

            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Data undangan cetak berhasil diambil.',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis_udangans,id',
            'stok' => 'required|integer|min:0',
            'terjual' => 'nullable|integer|min:0',
            'harga' => 'required|integer|min:0',
            'harga_modal' => 'nullable|integer|min:0',
            'ukuran_opp' => 'nullable|string|max:100',
            'promo' => 'nullable|integer|min:0',
            'favorite' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Simpan SEMUA file baru terlebih dahulu. Jika gagal, tidak ada
        // record yang dibuat dan file yang sudah terlanjur tersimpan dibersihkan.
        try {
            $imagePaths = $this->storeGambarFiles($request);
        } catch (Throwable $e) {
            $this->logUploadFailure($e, null, $request);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah gambar. Silakan coba lagi.',
            ], 500);
        }

        $data['gambar'] = $imagePaths;

        // Set default values
        $data['terjual'] = $data['terjual'] ?? 0;
        $data['favorite'] = $data['favorite'] ?? false;
        $data['promo'] = $data['promo'] ?? 0;

        try {
            $undangan = UndanganCetak::create($data);
        } catch (Throwable $e) {
            // DB gagal -> bersihkan file yang barusan di-upload.
            $this->deleteFilesQuietly($imagePaths);
            $this->logUploadFailure($e, null, $request);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan undangan cetak. Silakan coba lagi.',
            ], 500);
        }

        $undangan->append('thumbnail_url', 'image_urls');

        return response()->json([
            'success' => true,
            'message' => 'Undangan cetak berhasil ditambahkan.',
            'data' => $undangan,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $undangan = UndanganCetak::with('jenisUndangan')->find($id);

        if (! $undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        $undangan->append('thumbnail_url', 'image_urls');

        return response()->json([
            'success' => true,
            'message' => 'Detail undangan cetak berhasil diambil.',
            'data' => $undangan,
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $undangan = UndanganCetak::find($id);

        if (! $undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        // Client multipart mengirim hapus_gambar_lama sebagai string "true"/"false".
        // Normalisasi ke boolean agar aturan validasi `boolean` menerimanya.
        $this->normalizeHapusGambarLama($request);

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|max:255',
            'jenis_id' => 'sometimes|exists:jenis_udangans,id',
            'stok' => 'sometimes|integer|min:0',
            'terjual' => 'sometimes|integer|min:0',
            'harga' => 'sometimes|integer|min:0',
            'harga_modal' => 'sometimes|integer|min:0',
            'ukuran_opp' => 'nullable|string|max:100',
            'promo' => 'sometimes|integer|min:0',
            'favorite' => 'sometimes|boolean',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hapus_gambar_lama' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        unset($data['hapus_gambar_lama']);

        $oldImages = $this->decodeGambar($undangan->gambar);
        $hapusGambarLama = (bool) ($request->input('hapus_gambar_lama', false));

        // 1. Simpan SEMUA file baru terlebih dahulu. Jika ada satu saja yang
        //    gagal, seluruh file baru pada request ini dibersihkan dan record
        //    lama TIDAK diubah sama sekali.
        try {
            $newPaths = $this->storeGambarFiles($request);
        } catch (Throwable $e) {
            $this->logUploadFailure($e, $undangan->id, $request);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah gambar. Silakan coba lagi.',
            ], 500);
        }

        // 2. Update database (gambar lama masih utuh di storage & DB).
        try {
            DB::transaction(function () use ($undangan, $data, $newPaths, $oldImages, $hapusGambarLama) {
                if ($hapusGambarLama) {
                    $data['gambar'] = $newPaths;
                } elseif (! empty($newPaths)) {
                    $data['gambar'] = array_merge($oldImages, $newPaths);
                }

                $undangan->update($data);
            });
        } catch (Throwable $e) {
            // DB gagal -> bersihkan file baru agar tidak meninggalkan file yatim.
            $this->deleteFilesQuietly($newPaths);
            $this->logUploadFailure($e, $undangan->id, $request);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan perubahan undangan cetak. Silakan coba lagi.',
            ], 500);
        }

        // 3. Database sukses -> baru hapus file lama (jika replace diminta).
        if ($hapusGambarLama) {
            $this->deleteFilesQuietly($oldImages);
        }

        $undangan->refresh()->append('thumbnail_url', 'image_urls');

        return response()->json([
            'success' => true,
            'message' => 'Undangan cetak berhasil diperbarui.',
            'data' => $undangan,
        ]);
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(int $id): JsonResponse
    {
        $undangan = UndanganCetak::find($id);

        if (! $undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        // Hapus file gambar dari storage
        $images = $this->decodeGambar($undangan->gambar);
        foreach ($images as $path) {
            if (is_string($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $undangan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Undangan cetak berhasil dihapus.',
        ]);
    }

    /**
     * Delete a specific image from an undangan cetak.
     */
    public function deleteImage(int $id, int $imageIndex): JsonResponse
    {
        $undangan = UndanganCetak::find($id);

        if (! $undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        $images = $this->decodeGambar($undangan->gambar);

        if (! isset($images[$imageIndex])) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan pada index tersebut.',
            ], 404);
        }

        $path = $images[$imageIndex];
        if (is_string($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        array_splice($images, $imageIndex, 1);
        $undangan->gambar = $images;
        $undangan->save();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus.',
            'data' => $undangan->append('thumbnail_url', 'image_urls'),
        ]);
    }

    /**
     * Simpan semua file gambar dari request. Melempar RuntimeException jika
     * ada file yang tidak valid atau gagal disimpan; file yang sudah tersimpan
     * pada request ini ikut dibersihkan sebelum exception dilempar.
     *
     * @return array<int, string> daftar path relatif yang berhasil disimpan
     *
     * @throws Throwable
     */
    private function storeGambarFiles(Request $request): array
    {
        if (! $request->hasFile('gambar')) {
            return [];
        }

        $files = $request->file('gambar');
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        $stored = [];
        try {
            foreach ($files as $file) {
                if (! $file instanceof UploadedFile || ! $file->isValid()) {
                    throw new RuntimeException('File gambar tidak valid.');
                }

                $path = $file->store('undangan-cetak', ['disk' => 'public']);

                if (! is_string($path) || $path === '') {
                    throw new RuntimeException('Gagal menyimpan file gambar ke storage.');
                }

                $stored[] = $path;
            }
        } catch (Throwable $e) {
            $this->deleteFilesQuietly($stored);
            throw $e;
        }

        return $stored;
    }

    /**
     * Normalisasi hapus_gambar_lama dari string multipart ("true"/"false")
     * menjadi boolean agar lolos aturan validasi `boolean`.
     */
    private function normalizeHapusGambarLama(Request $request): void
    {
        if (! $request->has('hapus_gambar_lama') || ! is_string($request->input('hapus_gambar_lama'))) {
            return;
        }

        $value = strtolower(trim($request->input('hapus_gambar_lama')));

        if ($value === 'true') {
            $request->merge(['hapus_gambar_lama' => true]);
        } elseif ($value === 'false') {
            $request->merge(['hapus_gambar_lama' => false]);
        }
        // Nilai string lain dibiarkan -> aturan `boolean` akan menolak (422).
    }

    /**
     * Baca kolom gambar menjadi array, kompatibel dengan data legacy.
     *
     * Kolom gambar ber-cast `array`, jadi umumnya sudah berupa array. Data lama
     * bisa tersimpan sebagai string JSON, atau bahkan string JSON yang
     * ter-encode ganda (mis. '"[]"'), jadi semua bentuk tersebut dinormalisasi.
     */
    private function decodeGambar(mixed $gambar): array
    {
        if (is_array($gambar)) {
            return $gambar;
        }

        if (is_string($gambar)) {
            $decoded = json_decode($gambar, true);

            // Double-encoded: '"[]"' -> json_decode menghasilkan string '[]'.
            if (is_string($decoded)) {
                $nested = json_decode($decoded, true);

                return is_array($nested) ? $nested : [];
            }

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Hapus file dengan aman; kegagalan penghapusan diabaikan agar tidak
     * mengganggu alur utama.
     *
     * @param  array<int, mixed>  $paths
     */
    private function deleteFilesQuietly(array $paths): void
    {
        foreach ($paths as $path) {
            if (! is_string($path) || $path === '') {
                continue;
            }

            try {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            } catch (Throwable $e) {
                Log::warning('Gagal menghapus file gambar undangan.', [
                    'undangan_id' => null,
                    'file' => $path,
                    'disk' => 'public',
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Log kegagalan upload dengan konteks aman (tanpa API key / data sensitif).
     */
    private function logUploadFailure(Throwable $e, ?int $undanganId, Request $request): void
    {
        $context = [
            'undangan_id' => $undanganId,
            'disk' => 'public',
            'error' => $e->getMessage(),
        ];

        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            $files = $files instanceof UploadedFile ? [$files] : $files;
            $first = is_array($files) ? ($files[0] ?? null) : null;
            if ($first instanceof UploadedFile) {
                $context['file'] = $first->getClientOriginalName();
                $context['mime'] = $first->getClientMimeType();
                $context['size'] = $first->getSize();
            }
        }

        Log::error('Gagal mengunggah gambar undangan cetak.', $context);
    }
}
