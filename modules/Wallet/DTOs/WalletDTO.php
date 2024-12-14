<?php

namespace Modules\Wallet\DTOs;

class WalletDTO {

	public function __construct(
		public readonly string $id,
		public readonly float $balance,
	) {}
}
