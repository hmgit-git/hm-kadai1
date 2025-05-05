<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'content' => '資料請求'],
            ['id' => 2, 'content' => 'ご質問'],
            ['id' => 3, 'content' => 'その他'],
        ]);
    }
}
