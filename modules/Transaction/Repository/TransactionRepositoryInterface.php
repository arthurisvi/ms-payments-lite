<?php

namespace Modules\Transaction\Repository;
use Modules\Transaction\DTOs\TransactionDTO;

interface TransactionRepositoryInterface {
	public function beginDatabaseTransaction(): void;
	public function commitDatabaseTransaction(): void;
	public function rollbackDatabaseTransaction(): void;
	public function create(TransactionDTO $data): string;
}