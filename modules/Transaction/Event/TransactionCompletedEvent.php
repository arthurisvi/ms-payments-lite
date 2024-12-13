<?php

namespace Modules\Transaction\Event;

use Modules\Transaction\DTOs\TransactionInfoDTO;

class TransactionCompletedEvent {
	public string $transactionId;
	public string $payeeId;
	public string $payerId;
	public string $payeeName;
	public string $payerName;
	public string $payeeEmail;
	public string $payerEmail;
	public float $amount;

	public function __construct(TransactionInfoDTO $transactionInfo) {
		$this->transactionId = $transactionInfo->transactionId;
		$this->payeeId = $transactionInfo->payeeId;
		$this->payerId = $transactionInfo->payerId;
		$this->payeeName = $transactionInfo->payeeName;
		$this->payerName = $transactionInfo->payerName;
		$this->payeeEmail = $transactionInfo->payeeEmail;
		$this->payerEmail = $transactionInfo->payerEmail;
		$this->amount = $transactionInfo->amount;
	}

}
