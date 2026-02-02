<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                                      $id
 * @property string                                   $name
 * @property \Illuminate\Support\Collection<Category> categories
 */
class Type extends Model
{
    protected $table = 'types';
    protected $fillable = ['name'];

    const INCOME = 1;

    const EXPENDITURE = 2;

    const DEPOSIT = 3;

    /**
     * Получаем все категории по типу
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories() : HasMany
    {
        return $this->hasMany(Category::class);
    }
}
