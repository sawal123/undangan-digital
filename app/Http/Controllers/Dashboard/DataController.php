<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Qoute;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $request->merge([
            'slug' => Str::slug($request->input('slug')),
        ]);

        $validasi = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('data', 'slug')],
            'event_type_id' => 'nullable|exists:event_types,id',
        ]);

        $eventTypeId = $validasi['event_type_id'] ?? EventType::where('key', 'wedding')->value('id');
        $eventType = EventType::find($eventTypeId);
        $eventKey = $eventType?->key ?? 'wedding';

        $defaultTexts = match ($eventKey) {
            'birthday' => [
                'pembuka' => 'Dengan penuh kebahagiaan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara ulang tahun kami',
                'acara' => 'Acara ulang tahun ini insyaAllah akan dilaksanakan pada:',
                'penutup' => 'Merupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa.',
                'whatsapp' => 'Kepada {{tamu}}, Kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara ulang tahun kami.
            Silahkan kunjungi link berikut untuk membuka undangan:
            {{link}}
            Atas kehadiran dan doanya, kami ucapkan terimakasih.',
            ],
            'engagement' => [
                'pembuka' => 'Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pertunangan kami',
                'acara' => 'Acara pertunangan ini insyaAllah akan dilaksanakan pada:',
                'penutup' => 'Merupakan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa.',
                'whatsapp' => 'Kepada {{tamu}}, Kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pertunangan kami.
            Silahkan kunjungi link berikut untuk membuka undangan:
            {{link}}
            Atas kehadiran dan doanya, kami ucapkan terimakasih.',
            ],
            'pengajian' => [
                'pembuka' => 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pengajian kami',
                'acara' => 'Acara pengajian ini insyaAllah akan dilaksanakan pada:',
                'penutup' => 'Atas kehadiran dan doa Bapak/Ibu/Saudara/i, kami ucapkan terimakasih.',
                'whatsapp' => 'Kepada {{tamu}}, Kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pengajian kami.
            Silahkan kunjungi link berikut untuk membuka undangan:
            {{link}}
            Atas kehadiran dan doanya, kami ucapkan terimakasih.',
            ],
            'event' => [
                'pembuka' => 'Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara kami',
                'acara' => 'Acara ini akan dilaksanakan pada:',
                'penutup' => 'Atas kehadiran Bapak/Ibu/Saudara/i, kami ucapkan terimakasih.',
                'whatsapp' => 'Kepada {{tamu}}, Kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara kami.
            Silahkan kunjungi link berikut untuk membuka undangan:
            {{link}}
            Atas kehadirannya, kami ucapkan terimakasih.',
            ],
            default => [
                'pembuka' => "Kami mohon do'a & restunya atas pernikahan kami",
                'acara' => 'Kami bermaksud untuk mengundang saudara/(i) dalam acara pernikahan kami pada:',
                'penutup' => "Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih",
                'whatsapp' => 'Kepada {{tamu}}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami
            *{{nama_mempelai1}} & {{nama_mempelai2}}*
            Pesan ini merupakan undangan resmi dari kami. Silahkan kunjungi link berikut untuk membuka undangan anda:
            {{link}}
            Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih.',
            ],
        };

        DB::beginTransaction();

        try {
            $data = Data::create([
                'user_id' => Auth::user()->id,
                'theme_id' => null,
                'event_type_id' => $eventTypeId,
                'title' => $validasi['title'],
                'slug' => $validasi['slug'],
            ]);

            TeksUndangan::create([
                'data_id' => $data->id,
                'pembuka' => $defaultTexts['pembuka'],
                'acara' => $defaultTexts['acara'],
                'penutup' => $defaultTexts['penutup'],
            ]);
            teksWhatsApp::create([
                'data_id' => $data->id,
                'pesan' => $defaultTexts['whatsapp'],
            ]);
            Qoute::create([
                'data_id' => $data->id,
                'title' => ' وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا لِّتَسْكُنُوْٓا اِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةً ۗاِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ يَّتَفَكَّرُوْنَ
',
                'qoute' => '
Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu merasa tenang dan tentram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang. Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berfikir.
            ',
                'subtitle' => 'Ar Rum: 21',
            ]);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);

            return redirect()->back()->with('error', 'Gagal membuat undangan. Silakan coba lagi.')->withInput();
        }

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
