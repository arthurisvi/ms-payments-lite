<?php

namespace Modules\Transaction\Service;

use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\Transaction\Exception\InsufficientBalanceException;
use Modules\Transaction\Exception\UnauthorizedTransactionException;
use Modules\Transaction\Exception\MerchantCannotTransactionMoneyException;
use Modules\Transaction\Repository\TransactionRepositoryInterface;
use Modules\User\Service\UserService;
use Modules\Wallet\Service\WalletService;
use Modules\User\DTOs\UserTransactionDTO;
use Modules\User\Enum\UserType;
use Modules\Transaction\DTOs\TransactionDTO;

class TransactionService {

 	#[Inject]
	private EventDispatcherInterface $eventDispatcher;

	public function __construct(
		private TransactionRepositoryInterface $transactionRepository,
		private PaymentGatewayInterface $paymentGateway,
		private UserService $userService,
		private WalletService $walletService
	) {}

	public function performTransaction(string $payerId, string $payeeId, float $amount): void {
		$payerData = $this->userService->getUserDataToTransaction($payerId);

		$this->transactionRepository->beginDatabaseTransaction();

		try {
			$this->validateTransactionConditions($payerData, $amount);

			$transactionData = new TransactionDTO(
				payerId: $payerId,
				payeeId: $payeeId,
				amount: $amount
			);
			$this->transactionRepository->create($transactionData);

			$this->walletService->decrementBalanceByUserId($payerId, $amount);

			$this->walletService->incrementBalanceByUserId($payeeId, $amount);

			if (!$this->paymentGateway->authorizeTransaction()) {
				throw new UnauthorizedTransactionException();
			}

			$this->transactionRepository->commitDatabaseTransaction();

			$this->eventDispatcher->dispatch(new TransactionCompletedEvent($payeeId, $amount));
		} catch (\Exception $e) {
			$this->transactionRepository->rollbackDatabaseTransaction();
			throw $e;
		}

	}

	private function validateTransactionConditions(UserTransactionDTO $payerData, float $amount) {
		if ($payerData->type === UserType::MERCHANT) {
			throw new MerchantCannotTransactionMoneyException();
		}

		if ($payerData->balance < $amount) {
			throw new InsufficientBalanceException();
		}
	}
}