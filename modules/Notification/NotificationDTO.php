<?php

namespace Modules\Notification;

class NotificationDTO {

	public function __construct(
		public readonly string $recipientIdentifier,
		public readonly string $subject,
		public readonly string $message,
	) {}
}