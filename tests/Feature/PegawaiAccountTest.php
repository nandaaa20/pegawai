<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;

class PegawaiAccountTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'nip' => 'ADMIN-TEST',
            'email' => 'admin@example.test',
            'password' => 'test-password',
            'role' => 'admin',
        ]);
    }

    public function test_admin_creates_employee_and_sends_password_setup_link(): void
    {
        Notification::fake();
        $this->actingAs($this->admin());

        $this->post(route('admin.pegawai.store'), [
            'nip' => 'PEG-NEW',
            'nama_lengkap' => 'Pegawai Baru',
            'email' => 'new@example.test',
            'jenis_kelamin' => 'L',
            'status_kepegawaian' => 'aktif',
        ])->assertRedirect(route('admin.pegawai.index'));

        $pegawai = Pegawai::where('nip', 'PEG-NEW')->firstOrFail();
        $this->assertSame(12, (int) $pegawai->sisa_cuti);
        $this->assertSame(12, (int) $pegawai->kuota_cuti);
        $this->assertSame('new@example.test', $pegawai->user->email);
        $this->assertFalse(Hash::check('pegawai123', $pegawai->user->password));
        Notification::assertSentTo($pegawai->user, ResetPassword::class);
    }

    public function test_admin_reset_sends_link_without_changing_existing_password(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Pegawai',
            'nip' => 'PEG-RESET',
            'email' => 'reset@example.test',
            'password' => 'original-password',
            'role' => 'pegawai',
        ]);
        $pegawai = Pegawai::create([
            'user_id' => $user->id,
            'nip' => 'PEG-RESET',
            'nama_lengkap' => 'Pegawai',
            'kuota_cuti' => 12,
            'sisa_cuti' => 12,
        ]);
        $oldHash = $user->password;

        $this->actingAs($this->admin())
            ->post(route('admin.pegawai.reset-password', $pegawai))
            ->assertRedirect();

        $this->assertSame($oldHash, $user->fresh()->password);
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_employee_creation_requires_email(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.pegawai.store'), [
                'nip' => 'PEG-NOEMAIL',
                'nama_lengkap' => 'Tanpa Email',
            ])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('pegawai', ['nip' => 'PEG-NOEMAIL']);
    }
}
