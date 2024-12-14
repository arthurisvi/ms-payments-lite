<?php

namespace Modules\Notification\Template;

interface NotificationTemplateInterface {
	public function getSubject(): string;
	public function getMessage(object $context): string;
}