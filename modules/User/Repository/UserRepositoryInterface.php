<?php

namespace Modules\User\Repository;

interface UserRepositoryInterface {
	public function getById(string $id): UserDTO;
}