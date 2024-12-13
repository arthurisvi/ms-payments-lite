<?php

declare(strict_types=1);

namespace Modules\Transaction\Model;

use Hyperf\Database\Model\Events\Creating;
use Hyperf\DbConnection\Model\Model;
use Ramsey\Uuid\Guid\Guid;

/**
 * @property string $id
 * @property string $payer_id
 * @property string $payee_id
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Transaction extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'payer_id', 'payee_id', 'value'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setIncrementing(false);
        $this->setKeyType('string');
    }

    public function creating(Creating $event) {
        if (empty($this->id)) {
            $this->id = Guid::uuid4()->toString();
        }
    }
}
