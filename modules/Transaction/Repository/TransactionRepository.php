<?php

namespace Modules\Transaction\Repository;

use Hyperf\DbConnection\Db;
use Modules\Transaction\DTOs\TransactionDTO;
use Modules\Transaction\Model\Transaction;

class TransactionRepository implements TransactionRepositoryInterface {

	public function beginDatabaseTransaction(): void {
		Db::beginTransaction();
	}

	public function commitDatabaseTransaction(): void {
		Db::commit();
	}

	public function rollbackDatabaseTransaction(): void {
		Db::rollBack();
	}

	public function create(TransactionDTO $data): string {
		$transaction = Transaction::create([
			'payer_id' => $data->payerId,
			'payee_id' => $data->payeeId,
			'value' => $data->amount,
		]);

		return $transaction->id;
	}
}
