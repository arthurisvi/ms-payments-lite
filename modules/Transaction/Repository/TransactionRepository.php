<?php

namespace Modules\Transaction\Repository;

use Hyperf\DbConnection\Db;
use Modules\Transaction\DTOs\TransactionDTO;

class TransactionRepository implements TransactionRepositoryInterface {

	public function beginDatabaseTransaction(): void {
		Db::beginDatabaseTransaction();
	}

	public function commitDatabaseTransaction(): void {
		Db::commit();
	}

	public function rollbackDatabaseTransaction(): void {
		Db::rollBack();
	}

	public function create(TransactionDTO $data): void {
		Db::table('transactions')->insert([
			'payer_id' => $data->payerId,
			'payee_id' => $data->payeeId,
			'amount' => $data->amount,
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
