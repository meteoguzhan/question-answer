<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = [];

    static function getCount($questionId)
    {
        return Visitor::where('questionId', $questionId)->count();
    }
}
