<?php

declare(strict_types=1);

namespace Modules\Notification;

use Hyperf\Context\ApplicationContext;
use Modules\Transaction\Event\TransactionCompletedEvent;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class NotifyTransactionCompletedListener implements ListenerInterface  {

    public function __construct(
        protected ContainerInterface $container,
        protected NotificationService $notificationService
    ){}

    public function listen(): array {
        return [
            TransactionCompletedEvent::class
        ];
    }

    public function process(object $transaction): void {
        print_r("RECEBEU EVENTOO\n\n");
        print_r($transaction);
        print_r("\n\n");

        $notification = new NotificationDTO(
            recipientIdentifier: $transaction->payeeEmail,
            subject: 'Você recebeu uma nova transferência!',
            message: "Olá, {$transaction->payeeName}! Você acaba de receber uma
            transferência no valor de {$transaction->amount} de {$transaction->payerName}."
        );

        $this->notificationService->sendAsync($notification);
    }
}
