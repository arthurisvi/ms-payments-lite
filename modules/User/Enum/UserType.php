<?php

namespace Modules\User\Enum;

enum UserType: int {
	case COMMON = 1;
	case MERCHANT = 2;

	public function label(): string {
		return match($this) {
			self::COMMON => 'Common User',
			self::MERCHANT => 'Merchant',
		};
	}
}
