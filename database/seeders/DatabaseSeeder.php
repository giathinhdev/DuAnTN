<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            TablesTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            BookingsTableSeeder::class,
            OrderItemsTableSeeder::class,
            BlogsTableSeeder::class,
        ]);
    }
}
