<?php

namespace App\Http\Controllers\front\settings;

use App\Helper\fileUpload;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class indexController extends Controller
{
    public function index()
    {
        return view('front.settings.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'required',
            'email' => 'required|email'
        ]);
        $all = $request->except('_token');
        $c = User::where('email', $all['email'])->where('id', '!=', Auth::id())->count();
        if ($c != 0) {
            return redirect()->back()->with('status', 'Bu email sistemde mevcut');
        }
        $data = User::where('id', Auth::id())->get();
        $all['photo'] = fileUpload::changeUpload(Auth::id(), "user", $request->file('photo'), 0, $data, "field");
        $update = User::where('id', Auth::id())->update($all);
        if ($update) {
            return redirect()->back()->with('status', 'Ayarlar Güncellendi');
        } else {
            return redirect()->back()->with('status', 'Ayarlar Güncellenemedi !');
        }
    }

    public function password()
    {
        return view('front.settings.password');
    }

    public function passwordStore(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'retrypassword' => 'required'
        ]);

        $all = $request->except('_token');

        if ($all['password'] == $all['retrypassword']) {
            User::where('id', Auth::id())->update(['password' => Hash::make($all['password'])]);
            return redirect()->back()->with('status', 'Şifre değiştirildi');
        } else {
            return redirect()->back()->with('status', 'Şifreler Uyumsuz');
        }
    }

    public function notifications()
    {
        $data = Notification::where('receiverUserId', Auth::id())->orderBy('id', 'desc')->paginate(10);
        Notification::where('receiverUserId',Auth::id())->update(['isRead' => 0]);
        return view('front.settings.notifications', ['data' => $data]);
    }
}
