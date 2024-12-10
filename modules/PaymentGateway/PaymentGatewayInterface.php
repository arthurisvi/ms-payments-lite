<?php

namespace Modules\PaymentGateway;

interface PaymentGatewayInterface {
	public function authorizeTransaction(): bool;
}