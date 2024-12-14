<?php

namespace Modules\Transaction\Event;

use Modules\Transaction\DTOs\TransactionDTO;

class TransactionCompletedEvent {
	public string $transactionId;
	public string $payeeId;
	public string $payerId;
	public float $amount;

	public function __construct(string $transactionId, TransactionDTO $transactionInfo) {
		$this->transactionId = $transactionId;
		$this->payeeId = $transactionInfo->payeeId;
		$this->payerId = $transactionInfo->payerId;
		$this->amount = $transactionInfo->amount;
	}

}
