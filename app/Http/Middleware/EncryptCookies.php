<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Indicates if cookies should be serialized.
     * 쿠키 직렬화를 활성화/비활성화하기 serialize위해
     * 미들웨어 의 정적 특성을 변경할 수 있습니다.
     * @var bool
     */
    protected static $serialize = true;
}
