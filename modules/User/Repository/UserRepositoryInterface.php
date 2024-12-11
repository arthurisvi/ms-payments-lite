<?php

namespace Modules\User\Repository;

use Modules\User\DTOs\UserDTO;

interface UserRepositoryInterface {
	public function getById(string $id): UserDTO;
}