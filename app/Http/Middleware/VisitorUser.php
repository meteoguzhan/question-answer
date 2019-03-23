<?php

namespace App\Http\Middleware;

use App\Models\Question;
use App\Models\Visitor;
use Closure;
use Illuminate\Support\Facades\Auth;

class VisitorUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $id = $request->segment(2);
            $control = Question::where('id', $id)->count();
            if($control!=0){
                $c = Visitor::where('questionId', $id)->where('userId', Auth::id())->count();
                if ($c == 0) {
                    Visitor::create(['questionId' => $id, 'userId' => Auth::id()]);
                }
            }
        }
        return $next($request);
    }
}
