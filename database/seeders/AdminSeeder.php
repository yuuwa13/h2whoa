<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            $this->command->error('ADMIN_EMAIL and ADMIN_PASSWORD must be set in .env before seeding.');
            return;
        }

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name'     => 'Admin',
                'email'    => $email,
                'password' => Hash::make($password),
            ]
        );
    }
}
