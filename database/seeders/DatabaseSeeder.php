<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed the payment_methods table with default values
        \DB::table('payment_methods')->insertOrIgnore([
            ['payment_method_id' => 1, 'method_name' => 'Cash on Delivery'],
            ['payment_method_id' => 2, 'method_name' => 'G-Cash'],
        ]);
    }
}
