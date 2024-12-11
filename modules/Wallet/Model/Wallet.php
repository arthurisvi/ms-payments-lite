<?php

declare(strict_types=1);

namespace Modules\Wallet\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property string $id
 * @property string $user_id
 * @property string $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Wallet extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wallets';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'balance'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];
}