<?php
namespace App\Helper;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsHelper
{
    static function Insert($receiverId,$text,$type)
    {
        if(Auth::id() != $receiverId) {
            $array = [
                'userId' => Auth::id(),
                'type' => $type,
                'receiverUserId' => $receiverId,
                'text' => $text,
                'isRead'=>1
            ];

            Notification::create($array);
        }
    }
}
