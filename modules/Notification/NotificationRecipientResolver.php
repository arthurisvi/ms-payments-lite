<?php

namespace Modules\Notification;

use Modules\User\DTOs\UserDTO;

class NotificationRecipientResolver {

	public function resolve(NotificationChannel $channel, UserDTO $user): string {
		return match ($channel) {
			NotificationChannel::EMAIL => $user->email,
			NotificationChannel::SMS => /*$user->phone*/ '',
		};
	}
}
