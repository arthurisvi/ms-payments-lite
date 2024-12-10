<?php

use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\Transaction\Service\TransactionService;
use Modules\Transaction\Exception\InsufficientBalanceException;
use Modules\Transaction\Exception\MerchantCannotTransactionMoneyException;
use Modules\Transaction\Exception\UnauthorizedTransactionException;
use Modules\User\Service\UserService;
use Modules\Transaction\Repository\TransactionRepositoryInterface;
use Modules\User\DTOs\UserTransactionDTO;
use PHPUnit\Framework\TestCase;

class TransactionServiceTest extends TestCase {
	private $transactionRepository;
	private $paymentGateway;
	private $userService;
	private $transactionService;

	protected function setUp(): void {
		$this->transactionRepository = $this->createMock(TransactionRepositoryInterface::class);
		$this->paymentGateway = $this->createMock(PaymentGatewayInterface::class);
		$this->userService = $this->createMock(UserService::class);

		$this->transactionService = new TransactionService(
			$this->transactionRepository,
			$this->paymentGateway,
			$this->userService
		);
	}

	public function testPayerTypeMerchantThrowsException(): void {
		$this->userService
			->method('getUserTransactionData')
			->willReturn(new UserTransactionDTO('payer123', 2, 100.0));

		$this->expectException(MerchantCannotTransactionMoneyException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 50.0);
	}

	public function testInsufficientBalanceThrowsException(): void {
		$this->userService
			->method('getUserTransactionData')
			->willReturn(new UserTransactionDTO('payer123', 1, 30.0));

		$this->expectException(InsufficientBalanceException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 100.0);
	}

	public function testUnauthorizedTransactionThrowsException(): void {

		$this->userService
			->method('getUserTransactionData')
			->willReturn(new UserTransactionDTO('payer123', 1, 100.0));

		$this->paymentGateway
			->method('authorizeTransaction')
			->willReturn(false);

		$this->expectException(UnauthorizedTransactionException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 50.0);
	}
}
