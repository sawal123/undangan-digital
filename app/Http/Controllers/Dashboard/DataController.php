<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KelolaUndangan\Qoute;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->title);
        $validasi = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);

        if (Data::where('slug', $validasi['slug'])->exists()) {
            return redirect()->back()->with('error', 'Slug sudah digunakan, Cari slug lain!')->withInput();
        }

        $data = Data::create([
            'user_id' => Auth::user()->id,
            'theme_id' => null,
            'title' => $validasi['title'],
            'slug' => $validasi['slug']
        ]);

        TeksUndangan::create([
            'data_id' => $data->id,
            'pembuka' => "Kami mohon do'a & restunya atas pernikahan kami",
            'acara' => "Kami bermaksud untuk mengundang saudara/(i) dalam acara pernikahan kami pada:",
            'penutup' => "Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih",
        ]);
        teksWhatsApp::create([
            'data_id' => $data->id,
            'pesan' => "Kepada {{tamu}}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami
            *{{nama_mempelai1}} & {{nama_mempelai2}}*
            Pesan ini merupakan undangan resmi dari kami. Silahkan kunjungi link berikut untuk membuka undangan anda:
            {{link}}
            Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih."
        ]);
        Qoute::create([
            'data_id' => $data->id,
            'title' => " وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا لِّتَسْكُنُوْٓا اِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةً ۗاِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ يَّتَفَكَّرُوْنَ
",
            'qoute' => "
Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu merasa tenang dan tentram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang. Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berfikir.
            ",
            'subtitle' => "Ar Rum: 21"
        ]);

        return redirect()->route('dashboard.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Data $data)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Data $data) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Data $data)
    {
        //
    }
}
