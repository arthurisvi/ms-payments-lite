<?php

namespace Modules\Transaction\DTOs;

class TransactionDTO {

	public function __construct(
		public readonly string $payerId,
		public readonly string $payeeId,
		public readonly float $amount,
	) {}

}