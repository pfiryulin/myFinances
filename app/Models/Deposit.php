<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int              $id
 * @property int              $user_id
 * @property string           $name
 * @property int              $amount
 * @property string|null          $comment
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

    public const TO_DEPOSIT = 14;

    public const FROM_DEPOSIT = 15;

    /**
     * Get the deposit owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * create a new deposit
     *
     * @param int         $userId
     * @param string      $name
     * @param float       $amount
     * @param string|null $comment
     *
     * @return self
     */
    public static function register(
        int $userId,
        string $name,
        float $amount,
        string $comment = null,
    ) : self {
        return static::create([
            'user_id' => $userId,
            'name'    => $name,
            'amount'  => $amount,
            'comment' => $comment,
        ]);
    }
}
