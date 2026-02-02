<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//todo написать jobs для записи истории свободных сердств раз в сутки в полночь по МСК.
// На будущее подумать как учитывать часовой пояс пользователя для этого.
// Для jobs проверяеть налличие операций за прошедший день и вносить в историю, если такие были.

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int                        $user_id
 * @property int                        $free_money_id
 * @property float                      $amount
 * @property \Illuminate\Support\Carbon $date
 * @property-read \App\Models\FreeMoney $freeMoney
 * @property-read \App\Models\User      $user
 *
 */
class FreeMoneyHistory extends Model
{
    protected $fillable = [
        'user_id',
        'free_money_id',
        'amount',
        'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function freeMoney() : BelongsTo
    {
        return $this->belongsTo(FreeMoney::class);
    }

    /**
     * @param int $userId
     * @param int $freeMoneyId
     * @param int $oldAmount
     * @param     $date
     *
     * @return self
     */
    public static function register(int $userId, int $freeMoneyId, int $oldAmount, $date) : self
    {
        return static::create([
            'user_id'       => $userId,
            'free_money_id' => $freeMoneyId,
            'amount'        => $oldAmount,
            'date'          => $date,
        ]);
    }
}
