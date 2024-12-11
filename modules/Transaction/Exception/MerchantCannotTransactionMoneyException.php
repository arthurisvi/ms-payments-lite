<?php

namespace Modules\Transaction\Exception;

use Exception;

class MerchantCannotTransactionMoneyException extends Exception {

	public function __construct($message = "Usuários do tipo lojista não podem realizar transaçãos de dinheiro.", $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
