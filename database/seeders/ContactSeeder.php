<?php

namespace Database\Seeders;

use App\Models\Contact;
use Database\Factories\ContactFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory(30)->create();
    }
}
