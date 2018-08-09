<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cates = [
        	['name' => 'Bóng đá', 'slug' => 'bong-da'],
        	['name' => 'Thế giới', 'slug' => 'the-gioi'],
        	['name' => 'Thời trang', 'slug' => 'thoi-trang'],
        	['name' => 'Pháp luật', 'slug' => 'phap-luat'],
        	['name' => 'Ẩm thực', 'slug' => 'am-thuc'],
            ['name' => 'Sức khỏe', 'slug' => 'suc-khoe'],
            ['name' => 'Thể thao', 'slug' => 'The-thao'],
        	['name' => 'Du lịch', 'slug' => 'du-lich'],
        ];

        DB::table('categories')->insert($cates);
    }
}
