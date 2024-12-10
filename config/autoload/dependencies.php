<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Modules\Transaction\Repository\TransactionRepositoryInterface;
use Modules\Transaction\Repository\TransactionRepository;
use Modules\User\Repository\UserRepositoryInterface;
use Modules\User\Repository\UserRepository;
use Modules\Wallet\Repository\WalletRepositoryInterface;
use Modules\Wallet\Repository\WalletRepository;
use Modules\PaymentGateway\PaymentGatewayInterface;
use Modules\PaymentGateway\Hyperfpay;

return [
	TransactionRepositoryInterface::class => TransactionRepository::class,
	UserRepositoryInterface::class => UserRepository::class,
	WalletRepositoryInterface::class => WalletRepository::class,
	PaymentGatewayInterface::class => Hyperfpay::class,
];
