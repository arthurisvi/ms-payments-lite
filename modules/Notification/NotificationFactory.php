<?php

namespace Modules\Notification;

use Modules\Notification\Strategy\NotificationEmailStrategy;
use Modules\Notification\Strategy\NotificationSmsStrategy;
use Modules\Notification\Strategy\NotificationStrategyInterface;
use Modules\Notification\Types\NotificationChannelEnum;

class NotificationFactory {

	public static function createStrategy(NotificationChannelEnum $channel): NotificationStrategyInterface {
		return match ($channel) {
			NotificationChannelEnum::EMAIL => new NotificationEmailStrategy(),
			NotificationChannelEnum::SMS => new NotificationSmsStrategy(),
		};
	}

}