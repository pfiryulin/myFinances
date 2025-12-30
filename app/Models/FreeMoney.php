<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $amount
 *
 */
class FreeMoney extends Model
{
    protected $table = 'free_money';
    protected $fillable = [
        'user_id',
        'amount',
    ];
}
