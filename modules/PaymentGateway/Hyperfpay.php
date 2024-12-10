<?php

namespace Modules\PaymentGateway;

class Hyperfpay implements PaymentGatewayInterface {

	public function authorizeTransaction(): bool {
		return true;
	}

}