<?php

namespace Modules\Notification;

use Hyperf\Guzzle\ClientFactory;

class NotificationEmailStrategy implements NotificationStrategyInterface {

	public function __construct(
		private ClientFactory $clientFactory
	) {}

	public function sendNotification(NotificationDTO $notification): void {
		try {
			$client = $this->clientFactory->create();

			$client->post('https://util.devi.tools/api/v1/notify', [
				'json' => [
					'to' => $notification->recipientIdentifier,
					'subject' => $notification->subject,
					'message' => $notification->message
				]
			]);

		} catch (\Throwable $e) {
			print_r("Erro ao tentar enviar a notificação: " . $e->getMessage());
		}
	}
}