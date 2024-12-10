<?php

namespace Modules\Wallet\Service;

class WalletService {

	public function __construct(
		private WalletRepositoryInterface $walletRepository,
	) {}

	public function getBalanceByUserId(string $userId): float {
		return $this->walletRepository->getBalanceByUserId($userId);
	}

	public function incrementBalanceByUserId(string $userId, float $amount): void {
		$currentBalance = $this->walletRepository->getBalanceByUserId($userId);
		$newBalance = $currentBalance + $amount;
		$this->walletRepository->updateBalanceByUserId($userId, $newBalance);
	}

	public function decrementBalanceByUserId(string $userId, float $amount): void {
		$currentBalance = $this->walletRepository->getBalanceByUserId($userId);
		$newBalance = $currentBalance - $amount;
		$this->walletRepository->updateBalanceByUserId($userId, $newBalance);
	}
}