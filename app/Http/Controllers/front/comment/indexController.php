<?php

namespace App\Http\Controllers\front\comment;

use App\Helper\NotificationsHelper;
use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);
        $id = $request->route('id');
        $c = Question::where('id', $id)->count();
        if ($c != 0) {
            $all = $request->except('_token');
            $w = Question::where('id', $id)->get();
            $control = Comment::where('questionId', $id)->count();
            if ($control != 0) {
                $wControl = Comment::where('questionId', $id)->orderBy('id', 'desc')->limit(1)->get();
                if ($wControl[0]['userId'] == Auth::id()) {
                    return redirect()->back()->with('status', 'Üst üste yorum yapamassın!');
                }
            }
            $all['userId'] = Auth::id();
            $all['questionId'] = $id;

            $create = Comment::create($all);
            if ($create) {
                $text = User::getName(Auth::id()).' kişisi "'.$w[0]['title'].'" sorunuza cevap yazdı.';
                NotificationsHelper::Insert($w[0]['userId'], $text, NOTIFICATION_COMMENT);
                return redirect()->back()->with('status', 'Yorum başarı ile eklendi');
            } else {
                return redirect()->back()->with('status', 'Yorum eklenemedi!');
            }
        } else {
            abort(404);
        }
    }

    public function likeOrDislike($id)
    {
        if(!Auth::check()){
            return redirect()->back()->with('status', 'Beğenmek için giriş yapmalısınız!!');
        }
        $c = Comment::where('id', $id)->count();
        if ($c != 0) {

            $w = Comment::where('id', $id)->get();
            if ($w[0]['userId'] == Auth::id()) {
                return redirect()->back();
            }

            $control = LikeComment::where('commentId', $id)->where('userId', Auth::id())->count();
            if ($control == 0) {
                $text = User::getName(Auth::id()).' kişisi "'.$w[0]['text'].'" yorumunu beğendi.';
                NotificationsHelper::Insert($w[0]['userId'], $text, NOTIFICATION_LIKE);
                LikeComment::create(['commentId' => $id, 'userId' => Auth::id()]);
            } else {
                LikeComment::where('commentId', $id)->where('userId', Auth::id())->delete();
            }

            return redirect()->back();
        } else {
            abort(404);
        }
    }

    public function delete($id)
    {
        $c = Comment::where('id', $id)->where('userId', Auth::id())->count();
        if ($c != 0) {
            Comment::where('id', $id)->where('userId', Auth::id())->delete();
            LikeComment::where('commentId', $id)->delete();
            return redirect()->back();
        } else {
            abort(404);
        }
    }

    public function correct($id)
    {
        $c = Comment::where('id', $id)->count();
        if($c!=0){
            $w = Comment::where('id', $id)->get();
            $data = Question::where('id', $w[0]['questionId'])->get();
            if($data[0]['userId'] == Auth::id()){
                $control = Comment::where('questionId', $data[0]['id'])->where('isCorrect',1)->count();
                if($control == 0){
                    Comment::where('id', $id)->update(['isCorrect' => 1]);
                    return redirect()->back();
                }
            } else {
                abort(404);
            }
        }
    }
}
