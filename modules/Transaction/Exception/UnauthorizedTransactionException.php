<?php

namespace Modules\Transaction\Exception;

use App\Exception\BaseServiceException;

class UnauthorizedTransactionException extends BaseServiceException {
	protected int $httpStatusCode = 403;

	public function __construct($message = "Transação não autorizada pelo serviço autorizador.", $code = 2, \Throwable $previous = null) {
		parent::__construct($message, $code, $this->httpStatusCode, $previous);
	}
}
