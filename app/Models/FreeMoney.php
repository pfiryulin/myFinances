<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $user_id
 * @property int $amount
 * @property \App\Models\User $user
 * @property \App\Models\FreeMoneyHistory $freeMoneyHistory
 *
 * @mixin   \Illuminate\Database\Eloquent\Builder
 */
class FreeMoney extends Model
{
    protected $table = 'free_money';
    protected $fillable = [
        'user_id',
        'amount',
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function freeMoneyHistory() : HasMany
    {
        return $this->hasMany(FreeMoneyHistory::class, 'user_id', 'id');
    }
}
