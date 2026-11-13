<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Demo credentials must never be seeded into a production database.
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Akun demo hanya boleh dibuat pada environment local/testing.');
        }

        $providedPassword = env('SIMPEG_DEMO_PASSWORD');
        $password = is_string($providedPassword) && $providedPassword !== ''
            ? $providedPassword
            : Str::random(24);

        if (strlen($password) < 12) {
            throw new RuntimeException('SIMPEG_DEMO_PASSWORD minimal 12 karakter.');
        }

        $accounts = [
            ['nip' => '18200001', 'name' => 'Admin Demo', 'email' => 'admin@simpeg.test', 'role' => 'admin'],
            ['nip' => '18220001', 'name' => 'Pegawai Demo Satu', 'email' => 'pegawai1@simpeg.test', 'role' => 'pegawai'],
            ['nip' => '18220002', 'name' => 'Pegawai Demo Dua', 'email' => 'pegawai2@simpeg.test', 'role' => 'pegawai'],
        ];

        $created = [];
        DB::transaction(function () use ($accounts, $password, &$created): void {
            foreach ($accounts as $account) {
                // Re-running this seeder must not change existing login passwords or roles.
                $user = User::firstOrCreate(
                    ['nip' => $account['nip']],
                    [
                        'name' => $account['name'],
                        'email' => $account['email'],
                        'password' => Hash::make($password),
                        'role' => $account['role'],
                    ]
                );

                if ($user->wasRecentlyCreated) {
                    $created[] = $account;
                }

                if ($user->role === 'pegawai' && ! Pegawai::where('user_id', $user->id)->exists()) {
                    Pegawai::create([
                        'user_id' => $user->id,
                        'nip' => $user->nip,
                        'nama_lengkap' => $user->name,
                        'jabatan' => 'Staff',
                        'departemen' => 'IT',
                        'status_kepegawaian' => 'aktif',
                        'kuota_cuti' => 12,
                        'sisa_cuti' => 12,
                    ]);
                }
            }
        });

        if ($created !== []) {
            $this->command?->warn('Akun DEMO BARU dibuat (hanya untuk lokal):');
            foreach ($created as $account) {
                $this->command?->line("{$account['role']} | NIP: {$account['nip']} | {$account['email']}");
            }
            $this->command?->warn("Password akun baru: {$password}");
            $this->command?->warn('Simpan password ini secara pribadi. Seeder tidak mengubah password akun yang sudah ada.');
        } else {
            $this->command?->info('Akun demo sudah tersedia; password dan role yang ada tidak diubah.');
        }
    }
}
