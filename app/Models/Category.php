<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
