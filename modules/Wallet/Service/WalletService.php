<?php

namespace Modules\Wallet\Service;

use Modules\Wallet\Repository\WalletRepositoryInterface;

class WalletService {

	public function __construct(
		private WalletRepositoryInterface $walletRepository,
	) {}

	public function incrementBalance(string $walletId, float $amount): void {
		$wallet = $this->walletRepository->getById($walletId);
		$newBalance = $wallet->balance + $amount;
		$this->walletRepository->updateBalance($walletId, $newBalance);
	}

	public function decrementBalance(string $walletId, float $amount): void {
		$wallet = $this->walletRepository->getById($walletId);
		$newBalance = $wallet->balance - $amount;
		$this->walletRepository->updateBalance($walletId, $newBalance);
	}
 }