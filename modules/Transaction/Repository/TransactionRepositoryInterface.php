<?php

namespace Modules\Transaction\Repository;
use Modules\Transaction\DTOs\TransactionDTO;

interface TransactionRepositoryInterface {

	public function beginTransaction(): void;

	public function commitTransaction(): void;

	public function rollbackTransaction(): void;

	public function createTransaction(TransactionDTO $data): void;

}