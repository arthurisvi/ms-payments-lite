<?php

namespace Modules\Transaction\Exception;

use Exception;

class InsufficientBalanceException extends Exception {

	public function __construct($message = "Usuário não possui saldo suficiente para essa transactionência.", $code = 1, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
