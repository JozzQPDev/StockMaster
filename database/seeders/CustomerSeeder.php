<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'PÚBLICO GENERAL',
            'document_number' => '00000000',
            'document_type' => 'DNI',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
