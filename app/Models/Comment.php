<?php

namespace App\Models;

use App\Helper\mHelper;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    static function getCount($questionId)
    {
        return Comment::where('questionId', $questionId)->count();
    }

    static function isCorrectVariable($questionId)
    {
        return Comment::where('questionId', $questionId)->where('isCorrect', 1)->count();
    }

    static function getLastComment($questionId)
    {
        if(self::getCount($questionId)){
            $data = Comment::where('questionId', $questionId)->orderBy('id','desc')->limit(1)->get();
            return User::getName($data[0]['userId'])." tarafından ".mHelper::time_ago($data[0]['created_at'])." yazıldı.";
        } else {
            return "";
        }
    }
}
