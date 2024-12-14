<?php

namespace Modules\Notification;

interface NotificationTemplateInterface {
	public function getSubject(): string;
	public function getMessage(object $context): string;
}