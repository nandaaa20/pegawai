<?php

namespace Tests\Feature;

use App\Models\Kehadiran;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KehadiranTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $nip, string $role): User
    {
        return User::create([
            'name' => $role,
            'nip' => $nip,
            'email' => strtolower($nip).'@example.test',
            'password' => 'test-password',
            'role' => $role,
        ]);
    }

    public function test_admin_can_create_and_correct_attendance_without_duplicates(): void
    {
        $user = $this->makeUser('EMP-ATT', 'pegawai');
        $pegawai = Pegawai::create([
            'user_id' => $user->id,
            'nip' => 'EMP-ATT',
            'nama_lengkap' => 'Pegawai Kehadiran',
            'kuota_cuti' => 12,
            'sisa_cuti' => 12,
        ]);
        $this->actingAs($this->makeUser('ADM-ATT', 'admin'));

        $payload = [
            'pegawai_id' => $pegawai->id,
            'tanggal' => '2027-01-04',
            'status' => 'hadir',
        ];

        $this->post(route('admin.kehadiran.store'), $payload)
            ->assertRedirect(route('admin.kehadiran.index', ['tanggal' => '2027-01-04']));

        $this->post(route('admin.kehadiran.store'), array_merge($payload, [
            'status' => 'sakit',
            'keterangan' => 'Surat dokter',
        ]));

        $this->assertSame(1, Kehadiran::where('pegawai_id', $pegawai->id)->count());
        $this->assertSame('sakit', Kehadiran::where('pegawai_id', $pegawai->id)->firstOrFail()->status);
    }

    public function test_employee_cannot_submit_admin_attendance(): void
    {
        $this->actingAs($this->makeUser('EMP-LOCK', 'pegawai'))
            ->post(route('admin.kehadiran.store'), [
                'pegawai_id' => 999,
                'tanggal' => '2027-01-04',
                'status' => 'hadir',
            ])->assertForbidden();
    }

    public function test_invalid_attendance_status_is_rejected(): void
    {
        $this->actingAs($this->makeUser('ADM-VALID', 'admin'))
            ->post(route('admin.kehadiran.store'), [
                'pegawai_id' => 999,
                'tanggal' => '2027-01-04',
                'status' => 'libur',
            ])->assertSessionHasErrors(['pegawai_id', 'status']);
    }
}
