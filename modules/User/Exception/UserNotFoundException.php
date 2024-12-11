<?php

namespace Modules\User\Exception;

use App\Exception\BaseServiceException;

class UserNotFoundException extends BaseServiceException {
	protected int $httpStatusCode = 404;

	public function __construct(string $message = "Usuário não existente.", int $code = 4, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $this->httpStatusCode, $previous);
	}
}
