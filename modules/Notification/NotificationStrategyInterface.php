<?php

namespace Modules\Notification;

interface NotificationStrategyInterface {
	public function sendNotification(NotificationDTO $notification): void;
}