<?php

namespace Modules\Notification;

use Modules\Notification\NotificationDTO;

class NotificationBuilder {

	private string $recipientIdentifier;
	private string $subject;
	private string $message;

	public function setRecipient(string $recipient): self {
		$this->recipientIdentifier = $recipient;
		return $this;
	}

	public function setSubject(string $subject): self {
		$this->subject = $subject;
		return $this;
	}

	public function setMessage(string $message): self {
		$this->message = $message;
		return $this;
	}

	public function build(): NotificationDTO {
		return new NotificationDTO(
			$this->recipientIdentifier,
			$this->subject,
			$this->message
		);
	}
}
