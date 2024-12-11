<?php

namespace Modules\Wallet\Repository;

use Modules\Wallet\Model\Wallet;

class WalletRepository implements WalletRepositoryInterface {

	public function getBalanceByUserId(string $userId): float {
		$wallet = Wallet::where('user_id', $userId)->first();
		return $wallet ? (float) $wallet->balance : 0.0;
	}

	public function updateBalanceByUserId(string $userId, float $newBalance): void {
		$wallet = Wallet::where('user_id', $userId)->first();
		if ($wallet) {
			$wallet->update(['balance' => $newBalance]);
		}
	}
}
