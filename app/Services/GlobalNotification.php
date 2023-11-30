<?php
namespace App\Services;

use App\Enums\Notification;

class  GlobalNotification {
    public function __construct(
        public string $title,
        public string $message,
        public Notification $type
    ){

    }


}
