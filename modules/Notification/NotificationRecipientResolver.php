<?php

namespace Modules\Notification;

use Modules\Notification\Types\NotificationChannelEnum;
use Modules\User\DTOs\UserDTO;

class NotificationRecipientResolver {

	public function resolve(NotificationChannelEnum $channel, UserDTO $user): string {
		return match ($channel) {
			NotificationChannelEnum::EMAIL => $user->email,
			NotificationChannelEnum::SMS => /*$user->phone*/ '',
		};
	}
}
