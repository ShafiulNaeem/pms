<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laravel Book',
                'description' => 'A comprehensive guide to mastering Laravel.',
                'price' => 50.00,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Display a message in the console
        $this->command->info('Laravel Book product created!');
    }
}
