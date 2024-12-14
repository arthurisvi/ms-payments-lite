<?php

namespace Modules\Notification;

use Modules\Notification\NotificationEmailStrategy;
use Modules\Notification\NotificationSmsStrategy;
use Modules\Notification\NotificationStrategyInterface;

class NotificationFactory {

	public static function createStrategy(NotificationChannel $channel): NotificationStrategyInterface {
		return match ($channel) {
			NotificationChannel::EMAIL => new NotificationEmailStrategy(),
			NotificationChannel::SMS => new NotificationSmsStrategy(),
		};
	}

}