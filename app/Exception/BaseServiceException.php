<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

abstract class BaseServiceException extends ServerException {
	protected int $httpStatusCode = 500;

	public function __construct(string $message = "", int $code = 0, int $httpStatusCode = 500, \Throwable $previous = null) {
		$this->httpStatusCode = $httpStatusCode;
		parent::__construct($message, $code, $previous);
	}

	public function getHttpStatusCode(): int {
		return $this->httpStatusCode;
	}
}
