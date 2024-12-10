<?php

namespace Modules\Transaction\Repository;

use Hyperf\DbConnection\Db;
use Modules\Transaction\DTOs\TransactionDTO;

class TransactionRepository implements TransactionRepositoryInterface {

	public function beginTransaction(): void {
		Db::beginTransaction();
	}

	public function commitTransaction(): void {
		Db::commit();
	}

	public function rollbackTransaction(): void {
		Db::rollBack();
	}

	public function createTransaction(TransactionDTO $data): void {
		Db::table('transactions')->insert([
			'payer_id' => $data->payerId,
			'payee_id' => $data->payeeId,
			'amount' => $data->amount,
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
