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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function type() : BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
