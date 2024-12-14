<?php

namespace Modules\Notification;

use Hyperf\Di\Annotation\Inject;
use Modules\Notification\Template\NotificationTemplateInterface;
use Modules\Notification\Types\NotificationDTO;

class NotificationService {

	#[Inject]
	private NotificationRecipientResolver $recipientResolver;

	public function __construct() {}

	public function send(object $context, NotificationTemplateInterface $template, array $channels): void {
		foreach ($channels as $channel) {
			$notification = new NotificationDTO(
				recipientIdentifier: $this->recipientResolver->resolve($channel, $context->payee),
				subject: $template->getSubject(),
				message: $template->getMessage($context)
			);

			NotificationFactory::createStrategy($channel)->sendNotification($notification);
		}
	}
}
