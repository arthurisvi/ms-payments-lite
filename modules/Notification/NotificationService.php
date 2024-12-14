<?php

namespace Modules\Notification;

use Hyperf\Di\Annotation\Inject;

class NotificationService {

	#[Inject]
	private NotificationRecipientResolver $recipientResolver;

	public function __construct() {}

	public function send(object $context, NotificationTemplateInterface $template, array $channels): void {
		foreach ($channels as $channel) {
			$notification = (new NotificationBuilder())
				->setRecipient($this->recipientResolver->resolve($channel,
				$context->payee))
				->setSubject($template->getSubject())
				->setMessage($template->getMessage($context))
				->build();

			NotificationFactory::createStrategy($channel)->sendNotification($notification);
		}
	}
}
