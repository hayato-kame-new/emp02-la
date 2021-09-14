<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//　追加
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'department_id' => 'D01',
            'department_name' => '総務部',
        ];
        DB::table('departments')->insert($param);

        $param = [
            'department_id' => 'D02',
            'department_name' => '営業部',
        ];
        DB::table('departments')->insert($param);

        $param = [
            'department_id' => 'D03',
            'department_name' => '経理部',
        ];
        DB::table('departments')->insert($param);
    }

}
