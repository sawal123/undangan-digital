<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\Rundown as RundownComponent;
use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\Rundown;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RundownAcaraTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithInvitation(): array
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');

        $cat = Category::firstOrCreate(['category' => 'Wedding']);
        $ev = EventType::where('key', 'wedding')->first() ?? EventType::create(['name' => 'Pernikahan', 'key' => 'wedding']);

        $theme = Theme::create([
            'nama' => 'Test Theme',
            'category_id' => $cat->id,
            'event_type_id' => $ev->id,
            'path' => 'tema.wedding_blue',
            'demo' => 'theme-test',
        ]);

        $data = Data::create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'event_type_id' => $ev->id,
            'category_id' => $cat->id,
            'title' => 'Romeo & Juliet',
            'slug' => 'romeo-juliet-' . \Illuminate\Support\Str::random(6),
            'isActive' => true,
        ]);

        return [$user, $data];
    }

    public function test_user_can_access_rundown_page(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->assertOk()
            ->assertViewIs('livewire.dashboard.kelola.rundown');
    }

    public function test_user_can_create_rundown_with_is_active_toggle(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $acara = Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Akad Nikah',
            'vanue' => 'Masjid Raya',
            'alamat' => 'Jl. Merdeka No. 1',
            'date' => '2026-12-25',
            'jam_start' => '08:00',
            'jam_end' => '10:00',
            'zona_waktu' => 'WIB',
        ]);

        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->set('acara_id', $acara->id)
            ->set('nama_kegiatan', 'Ijab Qabul & Sungkeman')
            ->set('waktu_mulai', '08:30 WIB')
            ->set('waktu_selesai', '09:30 WIB')
            ->set('lokasi', 'Area Utama Masjid')
            ->set('keterangan', 'Dipimpin oleh Kepala KUA')
            ->set('is_active', true)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Jadwal rundown berhasil ditambahkan.');

        $this->assertDatabaseHas('rundowns', [
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Ijab Qabul & Sungkeman',
            'waktu_mulai' => '08:30 WIB',
            'waktu_selesai' => '09:30 WIB',
            'is_active' => 1,
            'sort' => 1,
        ]);
    }

    public function test_user_can_toggle_is_active(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $rundown = Rundown::create([
            'data_id' => $data->id,
            'nama_kegiatan' => 'Sesi Foto Keluarga',
            'waktu_mulai' => '10:00',
            'is_active' => true,
            'sort' => 1,
        ]);

        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->call('toggleActive', $rundown->id);

        $this->assertFalse((bool) $rundown->fresh()->is_active);

        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->call('toggleActive', $rundown->id);

        $this->assertTrue((bool) $rundown->fresh()->is_active);
    }

    public function test_user_can_reorder_rundown_items(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $r1 = Rundown::create(['data_id' => $data->id, 'nama_kegiatan' => 'Item 1', 'waktu_mulai' => '08:00', 'sort' => 1]);
        $r2 = Rundown::create(['data_id' => $data->id, 'nama_kegiatan' => 'Item 2', 'waktu_mulai' => '09:00', 'sort' => 2]);

        // Move Item 1 down
        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->call('moveDown', 1);

        $this->assertEquals(2, $r1->fresh()->sort);
        $this->assertEquals(1, $r2->fresh()->sort);

        // Move Item 1 back up
        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->call('moveUp', 2);

        $this->assertEquals(1, $r1->fresh()->sort);
        $this->assertEquals(2, $r2->fresh()->sort);
    }

    public function test_user_can_delete_rundown_and_sort_is_renormalized(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $r1 = Rundown::create(['data_id' => $data->id, 'nama_kegiatan' => 'Item 1', 'waktu_mulai' => '08:00', 'sort' => 1]);
        $r2 = Rundown::create(['data_id' => $data->id, 'nama_kegiatan' => 'Item 2', 'waktu_mulai' => '09:00', 'sort' => 2]);
        $r3 = Rundown::create(['data_id' => $data->id, 'nama_kegiatan' => 'Item 3', 'waktu_mulai' => '10:00', 'sort' => 3]);

        Livewire::test(RundownComponent::class, ['id' => $data->uid])
            ->call('delete', $r2->id);

        $this->assertDatabaseMissing('rundowns', ['id' => $r2->id]);
        $this->assertEquals(1, $r1->fresh()->sort);
        $this->assertEquals(2, $r3->fresh()->sort);
    }

    public function test_user_cannot_modify_other_users_rundown(): void
    {
        [$user1, $data1] = $this->createUserWithInvitation();
        [$user2, $data2] = $this->createUserWithInvitation();

        $rundown2 = Rundown::create([
            'data_id' => $data2->id,
            'nama_kegiatan' => 'Private Rundown',
            'waktu_mulai' => '08:00',
            'sort' => 1,
        ]);

        $this->actingAs($user1);

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        Livewire::test(RundownComponent::class, ['id' => $data1->uid])
            ->call('toggleActive', $rundown2->id);
    }

    public function test_active_rundown_is_rendered_in_theme_page(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $cat = Category::firstOrCreate(['category' => 'Wedding']);
        $darksweet = Theme::create([
            'nama' => 'Dark Sweet',
            'category_id' => $cat->id,
            'event_type_id' => $data->event_type_id,
            'path' => 'tema.darksweet.darksweet',
            'demo' => 'temademo.darksweet',
        ]);
        $data->theme_id = $darksweet->id;
        $data->save();

        \App\Models\Transaction::create([
            'data_id' => $data->id,
            'user_id' => $user->id,
            'payment_status' => 'SUCCESS',
            'gross_amount' => 50000,
        ]);

        \App\Models\KelolaUndangan\Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Romeo Montague',
            'nama_panggilan' => 'Romeo',
            'deskripsi' => 'Putra Tn. Montague',
            'image' => 'pria.png',
        ]);

        \App\Models\KelolaUndangan\Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Juliet Capulet',
            'nama_panggilan' => 'Juliet',
            'deskripsi' => 'Putri Tn. Capulet',
            'image' => 'wanita.png',
        ]);

        $acara = Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Akad Nikah',
            'date' => '2026-11-20',
            'jam_start' => '08:00',
            'jam_end' => '10:00',
            'zona_waktu' => 'WIB',
            'vanue' => 'Gedung Kencana',
            'alamat' => 'Jl. Pahlawan No. 10',
        ]);

        Rundown::create([
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Ijab Kabul Khidmat',
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:30',
            'keterangan' => 'Prosesi ijab kabul bersama penghulu',
            'lokasi' => 'Ruang Utama',
            'is_active' => true,
            'sort' => 1,
        ]);

        Rundown::create([
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Kegiatan Rahasia Nonaktif',
            'waktu_mulai' => '10:00',
            'is_active' => false,
            'sort' => 2,
        ]);

        $response = $this->get('/u/' . $data->slug);

        $response->assertStatus(200);
        $response->assertSee('Rundown Acara');
        $response->assertSee('Ijab Kabul Khidmat');
        $response->assertSee('08:30 - 09:30');
        $response->assertSee('Ruang Utama');
        $response->assertDontSee('Kegiatan Rahasia Nonaktif');
    }
}
