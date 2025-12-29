<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'type_id',
        'user_id',
    ];

    public function type() : HasOne
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeUserCategories(Builder $query, int $user_id) : Builder
    {
        return $query->where('user_id', $user_id)->orWhereNull('user_id');
    }
}
