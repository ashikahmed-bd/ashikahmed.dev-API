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
                'title' => 'Inventory',
                'description' => 'Inventory Management System',
                'price' => 200,
            ],
            [
                'title' => 'Hospital',
                'description' => 'Hospital Management System',
                'price' => 532,
            ],
        ]);
    }
}
