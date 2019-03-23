<?php

namespace App\Http\Controllers\front\tags;

use App\Models\Question;
use App\Models\QuestionTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        $data = QuestionTag::groupBy('name')->paginate(20);
        return view('front.tags.index', ['data' => $data]);
    }

    public function view($selflink)
    {
        $c = QuestionTag::where('selflink', $selflink)->count();
        if ($c != 0) {
            $w = QuestionTag::where('selflink', $selflink)->get();
            $data = Question::leftJoin('question_tags', 'questions.id', '=', 'question_tags.questionId')
                ->where('question_tags.selflink', $selflink)
                ->select(['questions.*'])
                ->paginate(10);

            return view('front.index', ['data' => $data, 'title' => $w[0]['name']]);
        } else {
            abort(404);
        }
    }
}
