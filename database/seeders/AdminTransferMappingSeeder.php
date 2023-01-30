<?php

namespace Database\Seeders;

use App\Models\AdminTransferMapping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTransferMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminTransferMapping::factory(10)->create();
    }
}
