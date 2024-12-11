<?php

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class RequestValidationExceptionHandler extends ExceptionHandler {

	public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface {
		if ($throwable instanceof ValidationException) {
			$errors = $throwable->validator->errors()->all();

			$data = json_encode([
				'message' => 'Ocorreu um erro na validação do corpo da requisição.',
				'errors' => $errors,
			], JSON_UNESCAPED_UNICODE);

			$this->stopPropagation();

			return $response
				->withStatus(400)
				->withHeader('Content-Type', 'application/json')
				->withBody(new SwooleStream($data));
		}

		return $response;
	}

	public function isValid(Throwable $throwable): bool {
		return $throwable instanceof ValidationException;
	}
}
