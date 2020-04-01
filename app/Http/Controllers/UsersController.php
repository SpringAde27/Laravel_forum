<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller 
{  
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create() 
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // $socialUser = \App\User::whereEmail($request->input('email'))->whereNull('password')->first();

        // 쿼리 스코프 사용
        $socialUser = \App\User::socialUser($request->get('email'))->first();

        if($socialUser) {
            return $this->updateSocialAccount($request, $socialUser);
        }

        return $this->createNativeAccount($request);
    }

    /**
     * A user has logged into the application with social account before.
     * But s/he tries to register an native account again.
     * So updating his/her existing social account with the information.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function updateSocialAccount(Request $request, \App\User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:4',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'password' => \bcrypt($request->input('password')),
        ]);

        auth()->login($user);
        flash(auth()->user()->name . '님 환영합니다.');

        return redirect(route('home'));
    }

    /**
     * A user tries to register a native account for the first time.
     * S/he has not logged into this service before with a social account.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */  
    protected function createNativeAccount(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:4',
        ]);

        $confirmCode = Str::random(60);

        $user = \App\User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        event(new \App\Events\UserCreated($user));

        return $this->respondCreated('가입하신 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해 주세요.','important');
    }

    public function confirm($code)
    {
        $user = \App\User::whereConfirmCode($code)->first();

        if (!$user) {
            return $this->respondCreated('URL이 정확하지 않습니다.');
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        flash(auth()->user()->name . '님 환영합니다. 가입 확인이 완료되었습니다.');

        return redirect('home');
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
