<?php

namespace Modules\User\Service;
use Modules\User\DTOs\UserTransactionDTO;
use Modules\Wallet\Service\WalletService;
use Modules\User\Repository\UserRepositoryInterface;

class UserService {

	public function __construct(
		private UserRepositoryInterface $userRepository
	) {}

	public function getUserDataToTransaction(string $userId): UserTransactionDTO {
		$user = $this->userRepository->getById($userId);

		if (!$user) {
			throw new UserNotFoundException("User with ID {$userId} not found.");
		}

		$balance = (new WalletService())->getBalanceByUserId($userId);

		return new UserTransactionDTO(
			id: $user->id,
			type: $user->type,
			balance: $balance
		);
	}

}