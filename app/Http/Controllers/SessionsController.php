<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // DB에서 사용자를 찾는데 사용
        if( !auth()->attempt($request->only('email', 'password'), $request->has('remember')) ){
            if (\App\User::socialUser($request->input('email'))->first()) {
                return $this->respondError('회원가입하지 않았습니다. 이전에 깃허브로 로그인하였습니다.');
            }

            return $this->respondError('이메일 또는 비밀번호가 맞지 않습니다.');
        }
        
        // 가입 확인 검사
        if( !auth()->user()->activated ) {
            auth()->logout();
            return $this->respondError('가입 확인해 주세요.');
        }

        flash(auth()->user()->name . '님, 안녕하세요:D');
        
        // auth미들웨어에서 로그인 페이지로 왔을 때, 사용자가 원래 접근하려 했던 URL로 리다이렉션
        return redirect()->intended('home');
    }

    protected function respondError($message)
    {
        flash()->error($message);

        return back()->withInput();
    }

    public function destroy()
    {
        auth()->logout();
        flash('또 방문해 주세요.');

        return redirect('/');
    }
}