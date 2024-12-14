<?php

namespace Modules\Wallet\Repository;

use Modules\Wallet\DTOs\WalletDTO;

interface WalletRepositoryInterface {
	public function getById (string $balanceId): ?WalletDTO;
	public function updateBalance(string $id, float $newBalance): void;
}