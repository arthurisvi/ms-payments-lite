<?php

namespace Modules\Notification\Strategy;

use Modules\Notification\Types\NotificationDTO;

class NotificationSmsStrategy implements NotificationStrategyInterface {

	public function sendNotification(NotificationDTO $notification): void {
		print_r('NOTIFICACAO SMS======');
		var_dump($notification);
		print_r("Notificação enviada por SMS");
		print_r("\n\n");
	}
}
