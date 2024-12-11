<?php

namespace Modules\User\DTOs;

use Modules\User\Enum\UserType;

class UserDTO {

	public function __construct(
		public readonly string $id,
		public readonly string $name,
		public readonly string $documentId,
		public readonly string $email,
		public readonly string $password,
		public readonly UserType $type
	) {}
}
