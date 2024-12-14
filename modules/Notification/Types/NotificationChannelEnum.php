<?php

namespace Modules\Notification\Types;

enum NotificationChannelEnum: string {
	case EMAIL = 'email';
	case SMS = 'sms';
}
