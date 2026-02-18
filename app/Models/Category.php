<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Builder;

/**
 * @property int              $id
 * @property string           $name
 * @property int              $type_id
 * @property int              $user_id
 * @property \App\Models\Type $type
 * @property \App\Models\User $user
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'type_id',
        'user_id',
    ];

    public const TO_DEPOSIT = 14;
    public const FROM_DEPOSIT = 15;

    public function type() : HasOne
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Отбор категорий пользователей и дефолтных категорий операций
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserCategories(Builder $query, int $user_id) : Builder
    {
        return $query->where('user_id', $user_id)->orWhereNull('user_id');
    }

    public function scopeCategoryItem(Builder $query, int $id, int $userId) : Builder
    {
        return $query->where('id', $id)
            ->where(function($query) use($userId) {
            $query->where('user_id', $userId)->orWhereNull('user_id');
        });
    }
}
