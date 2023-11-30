<?php
namespace App\Enums;

enum Notification:string {
    case Error='error';
    case Success='success';
    case Warning='warning';

}
