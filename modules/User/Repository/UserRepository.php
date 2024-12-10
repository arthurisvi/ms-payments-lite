<?php

namespace Modules\User\Repository;

class UserRepository implements UserRepositoryInterface {

	public function getById(string $id): UserDTO {
		return new UserDTO($id);
	}

}