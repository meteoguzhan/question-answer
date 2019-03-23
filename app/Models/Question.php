<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    static function getSelfLink($questionId)
    {
        $data = Question::where('id', $questionId)->get();
        return $data[0]['selflink'];
    }

    static function getTitle($questionId)
    {
        $data = Question::where('id', $questionId)->get();
        return $data[0]['title'];
    }

    static function likeQuestions($questionId)
    {
        $getQuestionsCategory = QuestionCategory::where('questionId', $questionId)->get();
        $data = Question::leftJoin('question_categories', 'questions.id', '=', 'question_categories.questionId')
            ->where('questions.id', '!=', $questionId)
            ->where(function ($data) use ($getQuestionsCategory){
                foreach ($getQuestionsCategory as $k => $v) {
                    $data->orWhere('question_categories.categoryId', $v['categoryId']);
                }
            });
        $data = $data->select(['questions.*'])->groupBy('id')->orderBy('id', 'desc')->limit(5)->get();
        return $data;
    }
}
