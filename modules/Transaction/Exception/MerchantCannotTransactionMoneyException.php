<?php

namespace Modules\Transaction\Exception;

use App\Exception\BaseServiceException;

class MerchantCannotTransactionMoneyException extends BaseServiceException {
	protected int $httpStatusCode = 403;

	public function __construct(string $message = "Usuários do tipo lojista não podem realizar transações.", int $code = 0, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $this->httpStatusCode, $previous);
	}
}
