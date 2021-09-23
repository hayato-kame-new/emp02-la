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
        // \App\Models\User::factory(10)->create();
        $this->call([UsersTableSeeder::class]);
        $this->call([DepartmentsTableSeeder::class]);
        $this->call([PhotosTableSeeder::class]);
    // 従テーブルを一番最後に書く
        $this->call([EmployeesTableSeeder::class]);
    }
}
