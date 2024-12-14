<?php

declare(strict_types=1);

namespace Modules\Notification;

use Modules\Transaction\Event\TransactionCompletedEvent;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Modules\Notification\Template\TransactionNotificationTemplate;
use Modules\Notification\Types\NotificationChannelEnum;
use Modules\User\Service\UserService;

#[Listener]
class NotifyTransactionCompletedListener implements ListenerInterface  {

    public function __construct(
        protected ContainerInterface $container,
        protected NotificationService $notificationService,
        private UserService $userService
    ){}

    public function listen(): array {
        return [
            TransactionCompletedEvent::class
        ];
    }

    public function process(object $transactionEvent): void {
        $payee = $this->userService->getUserDataById($transactionEvent->payeeId);
        $payer = $this->userService->getUserDataById($transactionEvent->payerId);

        $context = (object)[
            'payee' => $payee,
            'payer' => $payer,
            'amount' => $transactionEvent->amount,
        ];

        $notificationTemplate = new TransactionNotificationTemplate();

        $this->notificationService->send($context, $notificationTemplate, NotificationChannelEnum::cases());
    }

}
