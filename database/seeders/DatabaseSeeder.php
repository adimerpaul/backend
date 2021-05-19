<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //generamos 10 usuarios y por cada usuario se crean 5 productos
        \App\Models\User::factory(10)
                                    ->hasProductos(5)
                                    ->create();
    }
}
