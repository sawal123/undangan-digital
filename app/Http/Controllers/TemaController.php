<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TemaController extends Controller
{
    protected function getData($id)
    {
        return Crypt::decryptString($id);
    }

    public function index($slug)
    {
        return Data::where('slug', $slug)->first();
    }

    public function demo($token)
    {
        try {
            $payload = json_decode(Crypt::decryptString($token), true);

            if (! is_array($payload) || ! isset($payload['path'], $payload['data_id'], $payload['user_id'])) {
                return abort(404, 'Tema atau data tidak ditemukan.');
            }

            // Token dibuat khusus untuk pemilik data; tolak jika diakses user lain.
            if (! auth()->check() || (int) $payload['user_id'] !== (int) auth()->id()) {
                return abort(403, 'Anda tidak memiliki akses untuk melihat preview ini.');
            }

            $data = Data::with([
                'pria', 'wanita', 'birthdayProfile', 'eventDetail', 'acara', 'galery', 'sound',
                'FiturUcapan', 'streaming', 'kado.giftPay', 'fiturKado', 'imageKisah',
                'kisah.image', 'dataFont.titleFont', 'dataFont.subFont',
                'thumbnailWas', 'teksUndangan', 'coverUndangan',
                'setting', 'qoute', 'teksPenutup', 'ucapan.tamu',
            ])
                ->where('id', $payload['data_id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $preparedData = $this->prepareInvitationData($data, 'Nama Tamu (Contoh)');

            return view($payload['path'], $preparedData);
        } catch (\Exception $e) {
            \Log::error('Error saat demo tema: '.$e->getMessage());

            return abort(404, 'Tema atau data tidak ditemukan.');
        }
    }

    public function temademo($demo)
    {
        return view($demo);
    }

    public function visit($slug, $tamu = null)
    {
        try {
            $data = Data::with([
                'theme', 'eventType', 'pria', 'wanita', 'birthdayProfile', 'eventDetail', 'acara', 'galery', 'sound',
                'FiturUcapan', 'streaming', 'kado.giftPay', 'fiturKado', 'imageKisah',
                'kisah.image', 'dataFont.titleFont', 'dataFont.subFont',
                'thumbnailWas', 'teksUndangan', 'coverUndangan',
                'setting', 'qoute', 'teksPenutup', 'ucapan.tamu',
            ])->where('slug', $slug)->firstOrFail();

            if (! $data->canBeShared()) {
                return abort(403, 'Undangan belum aktif dan belum bisa dibagikan. Silakan upgrade ke premium untuk membagikan undangan ke tamu.');
            }

            // Validasi theme
            if (is_null($data->theme_id) || ! $data->theme) {
                session()->flash('message', 'Harap Pilih Tema Terlebih Dahulu!');

                return redirect()->back();
            }

            $preparedData = $this->prepareInvitationData($data, $tamu);

            return view($data->theme->path, $preparedData);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Undangan tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Error saat visit undangan: '.$e->getMessage());
            session()->flash('error', 'Terjadi kesalahan, silakan coba lagi.');

            return redirect()->back();
        }
    }

    protected function prepareInvitationData($data, $tamu = null)
    {
        // Pengambilan koleksi acara yang lebih handal
        $acara = $data->acara->get(1) ?? $data->acara->first();

        $thumbnailWa = $data->thumbnailWas;

        // Mencari tamu
        $ta = $tamu ? $data->tamu()->where('kode', $tamu)->first() : null;

        $hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin',
            'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',  'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $bulan = [
            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret',
            'Apr' => 'April',   'May' => 'Mei',      'Jun' => 'Juni',
            'Jul' => 'Juli',    'Aug' => 'Agustus',  'Sep' => 'September',
            'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember',
        ];

        $video = $data->galery->pluck('video')->filter()->toArray();
        $poto = $data->galery->pluck('poto')->filter()->toArray();

        return [
            'data' => $data,
            'hari' => $hari,
            'bulan' => $bulan,
            'tamu' => $ta->nama ?? $tamu ?? 'Tamu Undangan',
            'video' => $video,
            'poto' => $poto,
            'kode' => $tamu,
            'ucapan' => $data->ucapan()->with('tamu')->latest()->get(),
            'acara' => $acara,
            'thumbnailWa' => $thumbnailWa,
        ];
    }

    public function saveDoa(Request $request)
    {
        $va = $request->validate([
            'dataId' => 'required|exists:data,id',
            'nama' => 'nullable|string|max:50',
            'ucapan' => 'required|string|max:255',
            'status' => ['required', Rule::in(['hadir', 'tidak_hadir', 'tidak_datang', 'Hadir', 'Tidak Hadir', 'ragu', 'Datang Dong'])],
            'kode' => 'nullable|string|max:255',
        ], [
            'ucapan.required' => 'Ucapan tidak boleh kosong.',
            'ucapan.max' => 'Ucapan tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Pilih Kehadiran Kamu.',
        ]);
        $va['status'] = $this->normalizeAttendanceStatus($va['status']);

        $data = Data::findOrFail($va['dataId']);

        if (! $data->canBeShared()) {
            return $this->saveDoaError($request, 'Undangan belum aktif.', 403);
        }

        $fitur = FiturUcapan::where('data_id', $data->id)->first();

        if (! $fitur || ! $fitur->isActive) {
            return $this->saveDoaError($request, 'Fitur ucapan tidak tersedia.', 403);
        }

        $isPublicActive = $fitur?->publicIsActive ?? false;

        // Cek tamu dengan scope spesifik ke data_id undangan agar aman
        $tamu = Tamu::where('data_id', $data->id)
            ->where('kode', $va['kode'] ?? null)
            ->first();

        $addTamu = null;

        if (! $tamu && ! $isPublicActive) {
            return $this->saveDoaError($request, 'Anda Tidak Masuk Dalam Daftar Tamu Yang Diundang.', 403);
        } elseif (! $tamu && $isPublicActive) {
            if (empty($va['nama'])) {
                return redirect()->back()->withErrors([
                    'nama' => 'Nama tidak boleh kosong.',
                ])->withInput();
            }

        }

        $doa = DB::transaction(function () use ($data, $tamu, $isPublicActive, $va, &$addTamu) {
            $guestName = $tamu?->nama ?? $va['nama'] ?? null;

            $duplicate = Ucapan::where('data_id', $data->id)
                ->where('ucapan', $va['ucapan'])
                ->where('created_at', '>=', now()->subMinute())
                ->whereHas('tamu', function ($query) use ($guestName, $tamu) {
                    if ($tamu) {
                        $query->whereKey($tamu->id);

                        return;
                    }

                    $query->whereRaw('LOWER(nama) = ?', [Str::lower((string) $guestName)]);
                })
                ->exists();

            abort_if($duplicate, 429, 'Ucapan yang sama sudah dikirim.');

            if (! $tamu && $isPublicActive) {
                $addTamu = Tamu::create([
                    'data_id' => $data->id,
                    'kode' => Str::lower(Str::random(12)),
                    'nama' => $va['nama'],
                    'slug' => Str::slug($va['nama']),
                ]);
            }

            $guest = $tamu ?: $addTamu;

            return Ucapan::create([
                'data_id' => $data->id,
                'tamu_id' => $guest->id,
                'ucapan' => $va['ucapan'],
                'status' => $va['status'],
            ]);
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Ucapan doa berhasil dikirim',
                'doa' => [
                    'nama' => $tamu ? $tamu->nama : $addTamu->nama,
                    'ucapan' => $doa->ucapan,
                    'status' => $doa->status,
                    'created_at' => $doa->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->back()->with('message', 'Ucapan doa berhasil dikirim');
    }

    private function normalizeAttendanceStatus(string $status): string
    {
        return match (Str::lower(str_replace(' ', '_', $status))) {
            'hadir', 'datang_dong' => 'hadir',
            'tidak_hadir', 'tidak_datang' => 'tidak_hadir',
            default => 'ragu',
        };
    }

    private function saveDoaError(Request $request, string $message, int $status)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return redirect()->back()->with('error', $message);
    }
}
