<?php

namespace Modules\Transaction\Exception;

use App\Exception\BaseServiceException;

class InsufficientBalanceException extends BaseServiceException {
	protected int $httpStatusCode = 404;

	public function __construct($message = "Usuário não possui saldo suficiente para essa transação.", $code = 1, \Throwable $previous = null) {
		parent::__construct($message, $code, $this->httpStatusCode, $previous);
	}
}
