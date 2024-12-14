<?php

namespace Modules\Notification\Template;

class TransactionNotificationTemplate implements NotificationTemplateInterface {

	public function getSubject(): string {
		return 'Você recebeu uma nova transferência!';
	}

	public function getMessage(object $context): string {
		return "Olá, {$context->payee->name}! Você acaba de receber uma transferência
		no valor de {$context->amount} de {$context->payer->name}.";
	}
}