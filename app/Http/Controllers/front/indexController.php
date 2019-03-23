<?php

namespace App\Http\Controllers\front;

use App\Models\Comment;
use App\Models\Question;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        $data = Question::orderBy('id', 'desc')->paginate(8);
        return view('front.index', ['data' => $data, 'title' => 'Son Sorular']);
    }

    public function cevaplanmis()
    {
        $cevaplanmis = Question::join('comments', 'questions.id', '=', 'comments.questionId')
            ->select(['questions.*'])
            ->paginate(10);

        return view('front.index', ['data' => $cevaplanmis, 'title' => 'Cevaplanmış Sorular']);
    }

    public function cozumlenmis()
    {
        $cozumlenmis = Question::join('comments', 'questions.id', '=', 'comments.questionId')
            ->where('comments.isCorrect', 1)
            ->select(['questions.*'])
            ->paginate(10);

        return view('front.index', ['data' => $cozumlenmis, 'title' => 'Çözümlenmiş Sorular']);
    }

    public function view($selflink, $id)
    {
        //dd(Question::likeQuestions($id));
        $c = Question::where('id', $id)->where('selflink', $selflink)->count();
        if ($c != 0) {
            $data = Question::where('id', $id)->where('selflink', $selflink)->get();
            $comments = Comment::where('questionId', $id)->orderBy('id', 'desc')->get();
            return view('front.question.view', ['data' => $data, 'comments' => $comments]);
        } else {
            abort(404);
        }
    }
}
