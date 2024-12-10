<?php

namespace Modules\User\DTOs;

class UserTransactionDTO {

	public function __construct(
		public readonly string $id,
		public readonly int $type,
		public readonly float $balance,
	) {}

}