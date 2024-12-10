<?php

namespace Modules\Transaction\Exception;

use Exception;

class UnauthorizedTransactionException extends Exception {

	public function __construct($message = "Transactionência não autorizada pelo serviço autorizador.", $code = 2, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
