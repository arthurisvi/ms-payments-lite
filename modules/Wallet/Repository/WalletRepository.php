<?php

namespace Modules\Wallet\Repository;

use Modules\Wallet\DTOs\WalletDTO;
use Modules\Wallet\Model\Wallet;

class WalletRepository implements WalletRepositoryInterface {

	public function getById(string $id): WalletDTO {
		$wallet = Wallet::find($id);
		return new WalletDTO($wallet->id, $wallet->balance);
	}

	public function updateBalance(string $id, float $newBalance): void {
		Wallet::where('id', $id)->update(['balance' => $newBalance]);
	}
}
