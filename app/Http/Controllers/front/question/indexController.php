<?php

namespace App\Http\Controllers\front\question;

use App\Helper\mHelper;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\QuestionTag;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function create()
    {
        $category = Category::all();
        return view('front.question.create', ['categorys' => $category]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'category' => 'required',
            'tags' => 'required'
        ]);
        $all = $request->all();

        $category = $all['category'];
        unset($all['category']);

        $tags = explode(',', $all['tags']);
        unset($all['tags']);

        $all['userId'] = Auth::id();
        $all['selflink'] = mHelper::permalink($all['title']);

        $create = Question::create($all);
        if ($create) {
            foreach ($category as $k => $v) {
                QuestionCategory::create([
                    'questionId' => $create->id,
                    'categoryId' => $v
                ]);
            }

            foreach ($tags as $k => $v) {
                QuestionTag::create([
                    'name' => $v,
                    'selflink' => mHelper::permalink($v),
                    'questionId' => $create->id
                ]);
            }

            return redirect()->back()->with('status', 'Soru Başarı ile Soruldu');
        } else {
            return redirect()->back()->with('status', 'Soru Yayınlamadı.');
        }
    }

    public function edit($id)
    {
        $c = Question::where('id', $id)->where('userId', Auth::id())->count();
        $category = Category::all();
        if ($c != 0) {
            $data = Question::where('id', $id)->where('userId', Auth::id())->get();
            return view('front.question.edit', ['data' => $data, 'categorys' => $category]);
        } else {
            abort(404);
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Question::where('id', $id)->where('userId', Auth::id())->count();
        if ($c != 0) {
            $request->validate([
                'title' => 'required',
                'text' => 'required',
                'category' => 'required',
                'tags' => 'required'
            ]);
            $all = $request->except('_token');

            $category = $all['category'];
            unset($all['category']);

            QuestionCategory::where('questionId', $id)->delete();
            foreach ($category as $k => $v) {
                QuestionCategory::create(['questionId' => $id, 'categoryId' => $v]);
            }

            $tags = $all['tags'];
            unset($all['tags']);

            $tagsExplode = explode(',', $tags);
            QuestionTag::where('questionId', $id)->delete();
            foreach ($tagsExplode as $k => $v) {
                QuestionTag::create(['questionId'=>$id, 'name' => $v, 'selflink' => mHelper::permalink($v)]);
            }
            $all['selflink'] = mHelper::permalink($all['title']);

            Question::where('id', $id)->update($all);

            return redirect()->back()->with('status', 'Başarılı bir şekilde soru düzenlendi.');

        } else {
            abort(404);
        }
    }

    public function delete($id)
    {
        $c = Question::where('id', $id)->where('userId', Auth::id())->count();
        if($c!=0){
            Question::where('id', $id)->where('userId', Auth::id())->delete();
            QuestionCategory::where('questionId', $id)->delete();
            QuestionTag::where('questionId', $id)->delete();
            Comment::where('questionId',$id)->delete();
            Visitor::where('questionId', $id)->delete();

            return redirect(route('index'));
        } else {
            abort(404);
        }
    }
}
