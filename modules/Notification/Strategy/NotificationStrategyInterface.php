<?php

namespace Modules\Notification\Strategy;

use Modules\Notification\Types\NotificationDTO;

interface NotificationStrategyInterface {
	public function sendNotification(NotificationDTO $notification): void;
}