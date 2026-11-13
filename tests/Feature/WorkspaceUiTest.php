<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkspaceUiTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::create([
            'name' => $role === 'admin' ? 'Admin Dashboard' : 'Pegawai Dashboard',
            'nip' => $role === 'admin' ? 'UI-ADM-001' : 'UI-PEG-001',
            'email' => $role.'-ui@example.test',
            'password' => 'test-password',
            'role' => $role,
        ]);
    }

    public function test_login_has_static_css_fallback_for_missing_vite_assets(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('css/simpeg-auth-fallback.css');

        $this->assertFileExists(public_path('css/simpeg-auth-fallback.css'));
    }

    public function test_compiled_ui_bundle_is_shipped_and_loaded_on_every_layout(): void
    {
        $manifest = json_decode(file_get_contents(public_path('ui/manifest.json')), true);

        $this->assertIsArray($manifest);
        $css = $manifest['resources/css/app.css']['file'];
        $js = $manifest['resources/js/app.js']['file'];

        $this->assertFileExists(public_path('ui/'.$css));
        $this->assertFileExists(public_path('ui/'.$js));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('ui/'.$css)
            ->assertSee('ui/'.$js);

        $this->actingAs($this->user('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('ui/'.$css)
            ->assertSee('ui/'.$js);
    }

    public function test_all_administrator_pages_render_with_the_shared_ui_stylesheet(): void
    {
        $this->actingAs($this->user('admin'));

        foreach ([
            'admin.dashboard',
            'admin.pegawai.index',
            'admin.pegawai.create',
            'admin.cuti.index',
            'admin.kehadiran.index',
            'admin.kehadiran.create',
            'admin.laporan.pegawai',
            'admin.laporan.cuti',
            'admin.laporan.kehadiran',
            'profile.edit',
        ] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('ui/assets/app-', false);
        }
    }

    public function test_employee_pages_render_with_the_shared_ui_stylesheet(): void
    {
        $user = $this->user('pegawai');

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $user->nip,
            'nama_lengkap' => $user->name,
            'status_kepegawaian' => 'aktif',
            'kuota_cuti' => 12,
            'sisa_cuti' => 12,
        ]);

        $this->actingAs($user);

        foreach ([
            'pegawai.dashboard',
            'pegawai.cuti.index',
            'pegawai.cuti.create',
            'profile.edit',
        ] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('ui/assets/app-', false);
        }
    }

    public function test_admin_dashboard_renders_new_workspace_and_navigation(): void
    {
        $this->actingAs($this->user('admin'))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('WORKSPACE OVERVIEW')
            ->assertSee('Total pegawai')
            ->assertSee('simpeg-sidebar')
            ->assertSee('Manajemen cuti');
    }

    public function test_employee_dashboard_renders_without_an_employee_record(): void
    {
        $this->actingAs($this->user('pegawai'))
            ->get(route('pegawai.dashboard'))
            ->assertOk()
            ->assertSee('MY WORKSPACE')
            ->assertSee('Sisa cuti')
            ->assertSee('Ajukan cuti');
    }

    public function test_employee_dashboard_renders_leave_balance(): void
    {
        $user = $this->user('pegawai');

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $user->nip,
            'nama_lengkap' => $user->name,
            'status_kepegawaian' => 'aktif',
            'kuota_cuti' => 12,
            'sisa_cuti' => 9,
        ]);

        $this->actingAs($user)
            ->get(route('pegawai.dashboard'))
            ->assertOk()
            ->assertSee('Kuota cuti tahunan')
            ->assertSee('9');
    }

    public function test_admin_leave_index_renders_new_table_and_empty_state(): void
    {
        $this->actingAs($this->user('admin'))
            ->get(route('admin.cuti.index'))
            ->assertOk()
            ->assertSee('Daftar pengajuan')
            ->assertSee('Belum ada pengajuan cuti');
    }
}
