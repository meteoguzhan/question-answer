<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $guarded = [];

    static function getCount($categoryId)
    {
        return QuestionCategory::where('categoryId', $categoryId)->count();
    }

    static function isChecked($categoryId, $questionId)
    {
        $c = QuestionCategory::where('categoryId', $categoryId)->where('questionId', $questionId)->count();
        if ($c != 0) {
            return true;
        } else {
            return false;
        }
    }

    static function getCategoryList($questionId)
    {
        return Category::leftJoin('question_categories','question_categories.categoryId', '=','categories.id')
            ->where('question_categories.questionId', $questionId)
            ->select(['categories.*'])
            ->get();
    }
}
