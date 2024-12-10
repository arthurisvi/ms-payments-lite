<?php

namespace Modules\Wallet\Repository;

use Hyperf\DbConnection\Db;

class WalletRepository implements WalletRepositoryInterface {

	public function getBalanceByUserId(string $userId): float {
		return 1.00;
	}

	public function updateBalanceByUserId(string $userId, float $newBalance): void {

	}
}
