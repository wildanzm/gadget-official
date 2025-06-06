<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat User Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');

        // Membuat User
        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user1234'),
        ]);
        $user->assignRole('user');

        $faker = Faker::create('id_ID');

        $this->command->info('Membuat 5 data user tambahan dengan nama Indonesia...');

        // 3. Loop untuk membuat 5 user baru
        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name();
            $user = User::create([
                'name' => $name,
                // Membuat email unik sederhana berdasarkan nama
                'email' => strtolower(str_replace([' ', '.'], '', $name)) . '@gadgetofficial.com',
                'password' => Hash::make('password'), // Gunakan password default yang mudah diingat untuk testing
                'address' => $faker->address(), // Membuat alamat Indonesia palsu
                'phone' => $faker->phoneNumber(), // Membuat nomor telepon Indonesia palsu
                'email_verified_at' => now(), // Anggap email sudah terverifikasi
            ]);

            // Memberikan role 'user' ke user yang baru dibuat
            $user->assignRole('user');
        }

        $this->command->info('5 user tambahan berhasil dibuat.');
    }
}
