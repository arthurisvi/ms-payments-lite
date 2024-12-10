<?php

namespace Modules\Transaction\Event;

use Hyperf\Event\Contract\ListenerInterface;

class TransactionCompletedEvent {
	public string $payeeId;
	public float $amount;

	public function __construct(string $payeeId, float $amount) {
		$this->payeeId = $payeeId;
		$this->amount = $amount;
	}

}
