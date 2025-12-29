<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const DEFAULT_CATEGORIES = [
        1 => [
            'Зарплата',
            'Подработка',
            'Хобби',
            'Погашение кредита',
            'Погашение дебиторской задолжности (Вернули долг)',
        ],
        2 => [
            'Квартплата',
            'Еда',
            'Одежда',
            'Развлечения',
            'Хобби',
            'Транспорт',
            'Кредит',
            'Кредитная задолженность (кому-то одолжили в долг)',
        ],
        3 => [
            'Пополнение депозита',
            'Снятие с депозита',
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::hasTable('categories'))
        {
            foreach (self::DEFAULT_CATEGORIES as $type => $categories)
            {
                foreach ($categories as $category)
                {
                    DB::table('categories')->insert(
                        [
                            'name' => $category,
                            'type_id' => $type,
                            'user_id' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('categories', function (Blueprint $table)
        {
            if (Schema::hasTable('categories'))
            {
                foreach (self::DEFAULT_CATEGORIES as $type => $categories)
                {
                    foreach ($categories as $category)
                    {
                        DB::table('categories')->where('name', $category)
                        ->where('type_id', $type)->delete();
                    }
                }
            }
        });
    }
};
