<?php

namespace Modules\Transaction\Service;

use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\Transaction\Exception\InsufficientBalanceException;
use Modules\Transaction\Exception\UnauthorizedTransactionException;
use Modules\Transaction\Exception\MerchantCannotTransactionMoneyException;
use Modules\Transaction\Repository\TransactionRepositoryInterface;
use Modules\User\Service\UserService;
use Modules\User\DTOs\UserTransactionDTO;
use Modules\Transaction\DTOs\TransactionDTO;

class TransactionService {

 	#[Inject]
	private EventDispatcherInterface $eventDispatcher;

	public function __construct(
		private TransactionRepositoryInterface $transactionRepository,
		private PaymentGatewayInterface $paymentGateway,
		private UserService $userService
	) {}

	public function performTransaction(string $payerId, string $payeeId, float $amount): void {
		$payerData = $this->userService->getUserTransactionData($payerId);

		$this->validateTransactionConditions($payerData, $amount);

		$this->transactionRepository->beginDatabaseTransaction();

		try {

			$transactionData = new TransactionDTO(
				payerId: $payerId,
				payeeId: $payeeId,
				amount: $amount
			);
			$this->transactionRepository->create($transactionData);

			$this->userService->updateBalance($payerId, -$amount, 1);

			$this->userService->updateBalance($payeeId, $amount, 2);

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
		if ($payerData->type === 2) {
			throw new MerchantCannotTransactionMoneyException();
		}

		if ($payerData->balance < $amount) {
			throw new InsufficientBalanceException();
		}
	}
}