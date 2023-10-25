<?php

use Illuminate\Database\Seeder;
use App\Consulta;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Consulta::truncate();
        factory(Consulta::class, 10000)->create();
    }
}
