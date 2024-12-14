<?php

namespace Modules\Notification;

enum NotificationChannel: string {
	case EMAIL = 'email';
	case SMS = 'sms';
}
