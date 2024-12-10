<?php

namespace Modules\Wallet\Repository;

interface WalletRepositoryInterface {
	public function getBalanceByUserId(string $userId): float;
	public function updateBalanceByUserId(string $userId, float $newBalance): void;
}