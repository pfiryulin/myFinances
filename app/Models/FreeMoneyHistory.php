<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//todo написать jobs для записи истории свободных серджств раз в сутки в полночь по МСК.
// На будущее подумать как учитывать часовой пояс пользователя для этого.
// Для jobs проверяеть налличие операций за прошедший день и вносить в историю, если такие были.
class FreeMoneyHistory extends Model
{
    protected $fillable = [
        'user_id',
        'free_money_id',
        'amount',
        'date',
    ];
//    protected $casts = [
//        'amount' => 'float',
//        'date'   => Carbon::class,
//    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function freeMoney() : BelongsTo
    {
        return $this->belongsTo(FreeMoney::class);
    }

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
