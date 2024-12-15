<?php

namespace Tests\Integration;

use Hyperf\DbConnection\Db;
use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\Transaction\Repository\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Modules\Transaction\Service\TransactionService;
use Modules\User\Repository\UserRepository;
use Modules\User\Service\UserService;
use Modules\Wallet\Repository\WalletRepository;
use Modules\Wallet\Service\WalletService;

class TransactionServiceIntegrationTest extends TestCase {

	protected TransactionService $transactionService;

	private PaymentGatewayInterface $paymentGateway;

	protected function setUp(): void {
		$transactionRepository = new TransactionRepository();
		$this->paymentGateway = $this->createMock(PaymentGatewayInterface::class);
		$walletService = new WalletService(new WalletRepository());
		$userService = new UserService(new UserRepository());

		$this->transactionService = new TransactionService(
			$transactionRepository,
			$this->paymentGateway,
			$userService,
			$walletService
		);
	}

	public function testPerformTransaction(): void {
		$payer = $this->createUserWithWallet(1, 500.00);
		$payee = $this->createUserWithWallet(1, 200.00);

		$amount = 100.00;

		$this->paymentGateway
		->method('authorizeTransaction')
		->willReturn(true);

		$transactionId = $this->transactionService->performTransaction(
			$payer['id'],
			$payee['id'],
			$amount
		);

		$this->assertNotNull($transactionId, "A transação deve retornar um ID.");

		$this->assertNotNull($this->getTransactionById($transactionId), "A transação deve existir no banco de dados.");

		$payerWallet = $this->getWalletBalance($payer['wallet_id']);
		$payeeWallet = $this->getWalletBalance($payee['wallet_id']);

		$this->assertEquals(400.00, $payerWallet, "O saldo do pagador deve ser reduzido corretamente.");
		$this->assertEquals(300.00, $payeeWallet, "O saldo do recebedor deve ser incrementado corretamente.");
	}

	private function createUserWithWallet(int $type, float $balance): array {
		$userId = uniqid();
		$walletId = uniqid();

		Db::table('users')->insert([
			'id' => $userId,
			'name' => 'Test User',
			'document_id' => uniqid(),
			'email' => uniqid() . '@example.com',
			'password' => '123',
			'type' => $type,
		]);

		Db::table('wallets')->insert([
			'id' => $walletId,
			'user_id' => $userId,
			'balance' => $balance,
		]);

		return ['id' => $userId, 'wallet_id' => $walletId];
	}

	private function getWalletBalance(string $walletId): float {
		$wallet = Db::table('wallets')->where('id', $walletId)->first();
		return $wallet->balance;
	}

	private function getTransactionById(string $transactionId) {
		return Db::table('transactions')->where('id', $transactionId)->first();
	}
}
