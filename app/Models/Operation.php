<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int                  $user_id
 * @property int                  $category_id
 * @property int                  $type_id
 * @property float                $summ
 * @property string               $comment
 * @property \App\Models\User     $user
 * @property \App\Models\Category $category
 * @property \App\Models\Type     $type
 * @property int                  $deposit_id
 */
class Operation extends Model
{
    protected $table = 'operations';
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'type_id',
        'amount',
        'comment',
        'deposit_id',
    ];
    protected static array $map = [
        'category_id' => 'category',
        'type_id'     => 'type',
        'amount'      => 'amount',
        'comment'     => 'comment',
        'user_id'     => 'userId',
        'deposit_id'  => 'deposit',
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

    /**
     * @param array $fields
     *
     * @return self
     */
    public static function register(array $fields) : self
    {
        return static::create(static::mapping($fields));
    }

    /**
     * Updating the model
     *
     * @param array $fields
     *
     * @return bool
     */
    public function updateOperation(array $fields) : bool
    {
        return $this->update(static::mapping($fields));
    }

    /**
     * Converts incoming data to the model format
     *
     * @param array $fields
     *
     * @return array
     */
    private static function mapping(array $fields) : array
    {
        return [
            'user_id'     => $fields[self::$map['user_id']],
            'category_id' => $fields[self::$map['category_id']],
            'type_id'     => $fields[self::$map['type_id']],
            'amount'      => $fields[self::$map['amount']],
            'comment'     => ($fields[self::$map['comment']]) ?? null,
            'deposit_id'  => $fields[self::$map['deposit_id']] ?? null,
        ];
    }
}
