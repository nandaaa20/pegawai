<?php

namespace Tests\Feature;

use App\Models\Cuti;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CutiApprovalTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'nip' => 'ADMIN-001',
            'email' => 'admin@example.test',
            'password' => 'test-password',
            'role' => 'admin',
        ]);
    }

    private function leaveRequest(int $balance = 5, int $days = 3): array
    {
        $user = User::create([
            'name' => 'Pegawai Test',
            'nip' => 'PEG-001',
            'email' => 'pegawai@example.test',
            'password' => 'test-password',
            'role' => 'pegawai',
        ]);

        $pegawai = Pegawai::create([
            'user_id' => $user->id,
            'nip' => 'PEG-001',
            'nama_lengkap' => 'Pegawai Test',
            'status_kepegawaian' => 'aktif',
            'kuota_cuti' => 12,
            'sisa_cuti' => $balance,
        ]);

        $cuti = Cuti::create([
            'pegawai_id' => $pegawai->id,
            'tanggal_mulai' => '2027-01-04',
            'tanggal_selesai' => '2027-01-06',
            'jumlah_hari' => $days,
            'jenis_cuti' => 'tahunan',
            'alasan' => 'Keperluan keluarga',
            'status' => 'pending',
        ]);

        return [$pegawai, $cuti];
    }

    public function test_approval_deducts_balance_once(): void
    {
        [$pegawai, $cuti] = $this->leaveRequest();
        $this->actingAs($this->admin());

        $this->post(route('admin.cuti.updateStatus', $cuti), ['status' => 'disetujui'])
            ->assertRedirect(route('admin.cuti.show', $cuti));

        $this->assertSame(2, (int) $pegawai->fresh()->sisa_cuti);
        $this->assertSame('disetujui', $cuti->fresh()->status);

        $this->post(route('admin.cuti.updateStatus', $cuti), ['status' => 'disetujui']);
        $this->assertSame(2, (int) $pegawai->fresh()->sisa_cuti);
    }

    public function test_rejection_does_not_deduct_balance(): void
    {
        [$pegawai, $cuti] = $this->leaveRequest();
        $this->actingAs($this->admin());

        $this->post(route('admin.cuti.updateStatus', $cuti), ['status' => 'ditolak']);

        $this->assertSame(5, (int) $pegawai->fresh()->sisa_cuti);
        $this->assertSame('ditolak', $cuti->fresh()->status);
    }

    public function test_insufficient_balance_keeps_request_pending(): void
    {
        [$pegawai, $cuti] = $this->leaveRequest(2, 3);
        $this->actingAs($this->admin());

        $this->post(route('admin.cuti.updateStatus', $cuti), ['status' => 'disetujui'])
            ->assertSessionHas('error');

        $this->assertSame(2, (int) $pegawai->fresh()->sisa_cuti);
        $this->assertSame('pending', $cuti->fresh()->status);
    }

    public function test_employee_cannot_approve_leave(): void
    {
        [$pegawai, $cuti] = $this->leaveRequest();
        $this->actingAs($pegawai->user);

        $this->post(route('admin.cuti.updateStatus', $cuti), ['status' => 'disetujui'])
            ->assertForbidden();

        $this->assertSame('pending', $cuti->fresh()->status);
    }
}
