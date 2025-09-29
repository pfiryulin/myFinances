<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Зарплата',
                'type_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Кредит',
                'type_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Подработка',
                'type_id' => 2,
                'user_id' => 1,
            ],
            [
                'name' => 'Квартплата',
                'type_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Оплата кредита',
                'type_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Продукты',
                'type_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Обучение',
                'type_id' => 1,
                'user_id' => 1,
            ],
            [
                'name' => 'Развлечения',
                'type_id' => 1,
                'user_id' => 1,
            ],

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
