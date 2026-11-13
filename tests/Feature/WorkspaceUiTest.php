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
