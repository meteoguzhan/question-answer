<?php

namespace App\Http\Controllers\front\search;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class indexController extends Controller
{
    public function index()
    {
        if(isset($_GET['q'])){
            $q = strip_tags($_GET['q']);
            $data = Question::where('title', 'like','%'.$q.'%')->orderBy('id', 'desc')->paginate(10);
            return view('front.search.index', ['data' => $data, 'q' => $q]);
        } else {
            redirect()->back();
        }
    }
}
