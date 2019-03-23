<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $guarded = [];

    static function getIsReadCount()
    {
        return Notification::where('receiverUserId', Auth::id())->where('isRead',1)->count();
    }
}
