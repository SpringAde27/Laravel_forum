<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Say hello to visitors.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index() 
    {
        return view('welcome');
    }

    /**
     * Set locale.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function locale()
    {
        $cookie = cookie()->forever('my__locale', request('locale'));

        // 리다이렉션에 의해 URL로 이동 시 
        // Set-Cookie헤더를 전달하기 위해 queue()메서드로 예약.
        cookie()->queue($cookie);

        return ( $return = request('return') )
            ? redirect(urldecode($return))->withCookie($cookie)
            : redirect('/')->withCookie($cookie);
    }
}
