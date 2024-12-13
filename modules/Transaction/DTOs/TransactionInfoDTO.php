<?php

namespace Modules\Transaction\DTOs;

class TransactionInfoDTO {

	public function __construct(
		public readonly string $transactionId,
		public readonly string $payerId,
		public readonly string $payeeId,
		public readonly string $payerName,
		public readonly string $payeeName,
		public readonly string $payerEmail,
		public readonly string $payeeEmail,
		public readonly float $amount,
	) {}
}
