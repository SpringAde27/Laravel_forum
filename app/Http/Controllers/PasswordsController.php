<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasswordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRemind()
    {
        return view('passwords.remind');
    }

    public function postRemind(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $email = $request->get('email');
        $token = Str::random(64);

        \DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);

        event(new \App\Events\PasswordRemindCreated($email, $token));

        return $this->respondCreated('비밀번호 재설정에 관한 이메일을 발송했습니다. 메일박스를 확인해 주세요.', 'important');
    }

    public function getReset($token = null)
    {
        return view('passwords.reset', compact('token'));
    }

    public function postReset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed|min:4',
            'token' => 'required',
        ]);

        $token = $request->get('token');

        if( !\DB::table('password_resets')->whereToken($token)->first() ) {
            flash('URL이 정확하지 않습니다.')->error()->important();
            return back()->withInput();
        }

        \App\User::whereEmail($request->input('email'))->first()->update([
            'password' => bcrypt($request->input('password'))
        ]);

        \DB::table('password_resets')->whereToken($token)->delete();

        flash('비밀번호를 재설정 하였습니다. 새로운 비밀번호로 로그인 하세요.')->success()->important();

        return redirect('auth/login');
    }

    protected function respondCreated($message, $label = null)
    {
        if($label === 'important') {
            flash($message)->important();    
        } else {
            flash($message, $label);
        }

        return redirect('/');
    }
}