<?php

namespace Modules\User\DTOs;

use Modules\User\Enum\UserType;

class UserTransactionDTO {

	public function __construct(
		public readonly string $id,
		public readonly UserType $type,
		public readonly float $balance,
	) {}

}