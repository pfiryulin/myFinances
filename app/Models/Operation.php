<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $user_id
 * @property int    $category_id
 * @property int    $type_id
 * @property float  $summ
 * @property string $comment
 * @property \App\Models\User $user
 * @property \App\Models\Category $category
 * @property \App\Models\Type $type
 */
class Operation extends Model
{
    protected $table = 'operations';
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'type_id',
        'summ',
        'comment',
    ];

    /**
     * Получаем пользователя, который ввел операцию
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Получаем категорию операции
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Получаем тип операции
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type() : BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
