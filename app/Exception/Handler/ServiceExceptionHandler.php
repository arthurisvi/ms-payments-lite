<?php

namespace App\Exception\Handler;

use App\Exception\BaseServiceException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ServiceExceptionHandler extends ExceptionHandler {

	public function handle(Throwable $throwable, ResponseInterface $response) {
		if ($throwable instanceof BaseServiceException) {
			$data = json_encode([
				'error' => [
					'code' => $throwable->getCode(),
					'message' => $throwable->getMessage()
				]
			], JSON_UNESCAPED_UNICODE);

			$this->stopPropagation();

			return $response->withStatus($throwable->getHttpStatusCode())
				->withHeader('Content-Type', 'application/json')
				->withBody(new SwooleStream($data));
		}

		return $response;
	}

	public function isValid(Throwable $throwable): bool {
		return $throwable instanceof BaseServiceException;
	}
}
