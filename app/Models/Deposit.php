<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $name
 * @property int $amount
 * @property string $comment
 * @property \App\Models\User $user
 */

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'comment',
    ];

    /**
     * Получаем владельца депозита
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
