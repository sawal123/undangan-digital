<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\UndanganCetak;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $imagePaths = [];
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('undangan-cetak', 'public');
                $imagePaths[] = $path;
            }
            $data['gambar'] = $imagePaths;
        }

        // Set default values
        $data['terjual'] = $data['terjual'] ?? 0;
        $data['favorite'] = $data['favorite'] ?? false;
        $data['promo'] = $data['promo'] ?? 0;

        $undangan = UndanganCetak::create($data);
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

        if (!$undangan) {
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

        if (!$undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

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

        // Handle gambar: hapus lama jika diminta, upload baru
        if ($request->has('hapus_gambar_lama') && $request->hapus_gambar_lama) {
            $oldImages = is_array($undangan->gambar) ? $undangan->gambar : (json_decode($undangan->gambar, true) ?: []);
            foreach ($oldImages as $oldPath) {
                if (is_string($oldPath) && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $undangan->gambar = [];
            $undangan->save();
        }

        if ($request->hasFile('gambar')) {
            $imagePaths = is_array($undangan->gambar) ? $undangan->gambar : (json_decode($undangan->gambar, true) ?: []);
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('undangan-cetak', 'public');
                $imagePaths[] = $path;
            }
            $data['gambar'] = $imagePaths;
        }

        unset($data['hapus_gambar_lama']);

        $undangan->update($data);
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

        if (!$undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        // Hapus file gambar dari storage
        $images = is_array($undangan->gambar) ? $undangan->gambar : (json_decode($undangan->gambar, true) ?: []);
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

        if (!$undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Undangan cetak tidak ditemukan.',
            ], 404);
        }

        $images = is_array($undangan->gambar) ? $undangan->gambar : (json_decode($undangan->gambar, true) ?: []);

        if (!isset($images[$imageIndex])) {
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
}
