<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTag extends Model
{
    protected $guarded = [];

    static function getList($questionId)
    {
        $list = QuestionTag::where('questionId', $questionId)->get();
        return $list;
    }

    static function getImplode($questionId)
    {
        $returnArray = [];
        $list = QuestionTag::where('questionId', $questionId)->get();
        foreach ($list as $k => $v) {
            $returnArray[] = $v['name'];
        }
        return implode(',', $returnArray);
    }
}
