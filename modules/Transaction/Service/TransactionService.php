<?php

namespace Modules\Transaction\Service;

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
use Modules\Transaction\Event\TransactionCompletedEvent;

class TransactionService {

	public function __construct(
		private TransactionRepositoryInterface $transactionRepository,
		private PaymentGatewayInterface $paymentGateway,
		private UserService $userService,
		private WalletService $walletService,
		private EventDispatcherInterface $eventDispatcher
	) {}

	public function performTransaction(string $payerId, string $payeeId, float $amount): ?string {
		$payerData = $this->userService->getUserDataToTransaction($payerId);
		$payeeData = $this->userService->getUserDataToTransaction($payeeId);

		$this->transactionRepository->beginDatabaseTransaction();

		try {
			$this->validateTransactionConditions($payerData, $amount);

			$transactionData = new TransactionDTO(
				payerId: $payerId,
				payeeId: $payeeId,
				amount: $amount
			);

			$transactionId = $this->transactionRepository->create($transactionData);

			$this->walletService->decrementBalance($payerData->walletId, $amount);

			$this->walletService->incrementBalance($payeeData->walletId, $amount);

			if (!$this->paymentGateway->authorizeTransaction()) {
				throw new UnauthorizedTransactionException();
			}

			$this->transactionRepository->commitDatabaseTransaction();

			$this->eventDispatcher->dispatch(new TransactionCompletedEvent($transactionId, $transactionData));

			return $transactionId;
		} catch (\Throwable $e) {
			print_r("entrou no catchh\n\n");
			print_r($e->getMessage());
			print_r("\n\n");
			$this->transactionRepository->rollbackDatabaseTransaction();
			throw $e;
		}

		return null;
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