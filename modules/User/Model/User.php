<?php

declare(strict_types=1);

namespace Modules\User\Model;

use Hyperf\Database\Model\Relations\HasOne;
use Hyperf\DbConnection\Model\Model;
use Modules\Wallet\Model\Wallet;

/**
 * @property string $id
 * @property string $name
 * @property string $document_id
 * @property string $email
 * @property string $password
 * @property int $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setIncrementing(false);
        $this->setKeyType('string');
    }

    public function wallet(): HasOne {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }
}
