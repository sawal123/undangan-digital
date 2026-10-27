<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\Pengantin;
use App\Models\Data;
use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Wanita;
use App\Models\User;
use App\Services\InvitationMessageRenderer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UrutanMempelaiTest extends TestCase
{
    use RefreshDatabase;

    protected function createInvitationData(string $urutan = 'pria_wanita'): array
    {
        $user = User::factory()->create();

        $theme = \App\Models\Theme::create([
            'nama' => 'Wedding Blue',
            'category_id' => 1,
            'path' => 'tema.wedding_blue',
            'demo' => 'temademo.wedding_blue',
            'thumbnail' => 'thumbnail/wb.png',
        ]);

        $data = Data::create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'title' => 'The Wedding of Romeo & Juliet',
            'slug' => 'romeo-juliet-' . uniqid(),
            'urutan_mempelai' => $urutan,
            'isActive' => 1,
        ]);

        \App\Models\Transaction::create([
            'data_id' => $data->id,
            'user_id' => $user->id,
            'payment_status' => 'SUCCESS',
            'gross_amount' => 50000,
        ]);

        $pria = Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Romeo Montague',
            'nama_panggilan' => 'Romeo',
            'deskripsi' => 'Putra dari Tn. Montague',
            'image' => 'pria.png',
        ]);

        $wanita = Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Juliet Capulet',
            'nama_panggilan' => 'Juliet',
            'deskripsi' => 'Putri dari Tn. Capulet',
            'image' => 'wanita.png',
        ]);

        return [$user, $data->fresh(['pria', 'wanita', 'theme'])];
    }

    public function test_default_urutan_mempelai_is_pria_wanita(): void
    {
        [$user, $data] = $this->createInvitationData();

        $this->assertEquals('pria_wanita', $data->urutan_mempelai);
        $this->assertFalse($data->is_wanita_first);
        $this->assertEquals('Romeo & Juliet', $data->couple_name);
        $this->assertEquals('Romeo Montague & Juliet Capulet', $data->couple_full_name);
        $this->assertEquals('Romeo Montague', $data->first_person?->nama_lengkap);
        $this->assertEquals('Juliet Capulet', $data->second_person?->nama_lengkap);
    }

    public function test_wanita_first_accessor_returns_correct_order(): void
    {
        [$user, $data] = $this->createInvitationData('wanita_pria');

        $this->assertEquals('wanita_pria', $data->urutan_mempelai);
        $this->assertTrue($data->is_wanita_first);
        $this->assertEquals('Juliet & Romeo', $data->couple_name);
        $this->assertEquals('Juliet Capulet & Romeo Montague', $data->couple_full_name);
        $this->assertEquals('Juliet Capulet', $data->first_person?->nama_lengkap);
        $this->assertEquals('Romeo Montague', $data->second_person?->nama_lengkap);
    }

    public function test_livewire_pengantin_can_toggle_urutan_mempelai(): void
    {
        [$user, $data] = $this->createInvitationData('pria_wanita');

        $this->actingAs($user);

        Livewire::test(Pengantin::class, ['id' => $data->uid])
            ->assertSet('urutanMempelai', 'pria_wanita')
            ->call('setUrutan', 'wanita_pria')
            ->assertSet('urutanMempelai', 'wanita_pria');

        $this->assertEquals('wanita_pria', $data->fresh()->urutan_mempelai);

        Livewire::test(Pengantin::class, ['id' => $data->uid])
            ->call('setUrutan', 'pria_wanita')
            ->assertSet('urutanMempelai', 'pria_wanita');

        $this->assertEquals('pria_wanita', $data->fresh()->urutan_mempelai);
    }

    public function test_invitation_message_renderer_respects_couple_order(): void
    {
        [$user, $dataPria] = $this->createInvitationData('pria_wanita');
        $renderer = app(InvitationMessageRenderer::class);

        $tamuPria = \App\Models\KelolaUndangan\Tamu::create([
            'data_id' => $dataPria->id,
            'nama' => 'Budi Santoso',
            'kode' => 'budi123',
            'slug' => 'budi-santoso',
        ]);

        $template = "Kepada {{nama_tamu}}, hadir di pernikahan {{nama_mempelai1}} & {{nama_mempelai2}} (Pasangan: {{nama_pasangan}})";

        $renderedPria = $renderer->render($dataPria, $tamuPria, $template);
        $this->assertStringContainsString('Romeo & Juliet', $renderedPria);
        $this->assertStringContainsString('Pasangan: Romeo & Juliet', $renderedPria);

        [$user2, $dataWanita] = $this->createInvitationData('wanita_pria');
        $tamuWanita = \App\Models\KelolaUndangan\Tamu::create([
            'data_id' => $dataWanita->id,
            'nama' => 'Siti Aminah',
            'kode' => 'siti123',
            'slug' => 'siti-aminah',
        ]);

        $renderedWanita = $renderer->render($dataWanita, $tamuWanita, $template);
        $this->assertStringContainsString('Juliet & Romeo', $renderedWanita);
        $this->assertStringContainsString('Pasangan: Juliet & Romeo', $renderedWanita);
    }

    public function test_theme_page_renders_successfully_with_wanita_first(): void
    {
        [$user, $data] = $this->createInvitationData('wanita_pria');

        $response = $this->get('/u/' . $data->slug);

        $response->assertStatus(200);
        $response->assertSee('Juliet &amp; Romeo', false);
    }
}
