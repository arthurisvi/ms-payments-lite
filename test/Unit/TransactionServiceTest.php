<?php

use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\Transaction\Service\TransactionService;
use Modules\Transaction\Exception\InsufficientBalanceException;
use Modules\Transaction\Exception\MerchantCannotTransactionMoneyException;
use Modules\Transaction\Exception\UnauthorizedTransactionException;
use Modules\User\Service\UserService;
use Modules\Transaction\Repository\TransactionRepositoryInterface;
use Modules\User\Enum\UserType;
use Modules\Wallet\Service\WalletService;
use Modules\User\DTOs\UserTransactionDTO;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class TransactionServiceTest extends TestCase {
	private $transactionRepository;
	private $paymentGateway;
	private $userService;
	private $transactionService;
	private $walletService;

	protected function setUp(): void {
		$this->transactionRepository = $this->createMock(TransactionRepositoryInterface::class);
		$this->paymentGateway = $this->createMock(PaymentGatewayInterface::class);
		$this->userService = $this->createMock(UserService::class);
		$this->walletService = $this->createMock(WalletService::class);

		$this->transactionService = new TransactionService(
			$this->transactionRepository,
			$this->paymentGateway,
			$this->userService,
			$this->walletService,
			$this->createMock(EventDispatcherInterface::class)
		);
	}

	public function testPayerTypeMerchantThrowsException(): void {
		$this->userService
			->method('getUserDataToTransaction')
			->willReturn(new UserTransactionDTO('payer123', UserType::MERCHANT, 100.0));

		$this->expectException(MerchantCannotTransactionMoneyException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 50.0);
	}

	public function testInsufficientBalanceThrowsException(): void {
		$this->userService
			->method('getUserDataToTransaction')
			->willReturn(new UserTransactionDTO('payer123', UserType::COMMON, 30.0));

		$this->expectException(InsufficientBalanceException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 100.0);
	}

	public function testUnauthorizedTransactionThrowsException(): void {

		$this->userService
			->method('getUserDataToTransaction')
			->willReturn(new UserTransactionDTO('payer123', UserType::COMMON, 100.0));

		$this->paymentGateway
			->method('authorizeTransaction')
			->willReturn(false);

		$this->expectException(UnauthorizedTransactionException::class);

		$this->transactionService->performTransaction('payer123', 'payee456', 50.0);
	}
}
