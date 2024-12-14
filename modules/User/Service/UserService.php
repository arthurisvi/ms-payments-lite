<?php

namespace Modules\User\Service;

use Modules\User\DTOs\UserDTO;
use Modules\User\DTOs\UserTransactionDTO;
use Modules\User\Exception\UserNotFoundException;
use Modules\Wallet\Service\WalletService;
use Modules\User\Repository\UserRepositoryInterface;

class UserService {

	public function __construct(
		private UserRepositoryInterface $userRepository,
		private WalletService $walletService
	) {}

	public function getUserDataById(string $userId): ?UserDTO {
		return $this->userRepository->getById($userId);
	}

	public function getUserDataToTransaction(string $userId): UserTransactionDTO {
		$user = $this->userRepository->getByIdWithWallet($userId);

		if (empty($user)) {
			throw new UserNotFoundException();
		}

		return new UserTransactionDTO(
			id: $user->id,
			type: $user->type,
			walletId: $user->walletId,
			balance: $user->walletBalance
		);
	}

}