<?php

namespace Modules\User\Repository;

use Modules\User\DTOs\UserDTO;
use Modules\User\Enum\UserType;
use Modules\User\Model\User;

class UserRepository implements UserRepositoryInterface {

	public function getById(string $id): UserDTO {
		$user = User::find($id);

		return new UserDTO(
			id: $user->id,
			name: $user->name,
			documentId: $user->document_id,
			email: $user->email,
			password: $user->password,
			type: UserType::from($user->type)
		);
	}

}