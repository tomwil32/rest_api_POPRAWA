<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        People::factory()
            ->count(20)
            ->hasInvoices(10)
            ->create();

        People::factory()
            ->count(80)
            ->hasInvoices(5)
            ->create();

        People::factory()
            ->count(95)
            ->hasInvoices(3)
            ->create();

        People::factory()
            ->count(5)
            ->create();
    }
}
