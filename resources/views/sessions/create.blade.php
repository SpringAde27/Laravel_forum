@extends('layouts.app')

@section('style')
  <style>
    .login-or {
      position: relative;
      margin-top: 20px;
      margin-bottom: 20px;
      padding-top: 15px;
      padding-bottom: 15px;
    }

    .span-or {
      display: block;
      position: absolute;
      left: 50%;
      top: 0;
      margin-left: -25px;
      background-color: #fff;
      width: 50px;
      text-align: center;
    }

    .hr-or {
      margin-top: 0px !important;
      margin-bottom: 0px !important;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
              로그인
            <span class="text-muted d-block">
              깃허브 계정으로 로그인하세요.<br>{{ config('project.name') }} 계정으로도 로그인할 수 있습니다.
            </span>
          </div>

          <div class="card-body">
            <div class="form-group">
              <a class="btn btn-outline-secondary btn-lg btn-block" href="{{ route('social.login', ['github']) }}">
                <strong>
                  <i class="fa fa-github"></i>
                  Github 계정으로 로그인하기
                </strong>
              </a>
            </div>
        
            <div class="login-or">
              <hr class="hr-or">
              <span class="span-or">or</span>
            </div>
            
            <form action="{{ route('sessions.store') }}" method="POST" role="form" class="form__auth">
              {!! csrf_field() !!}
            
              <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}" autofocus/>
                {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
              </div>
            
              <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="비밀번호">
                {!! $errors->first('password', '<span class="form-error">:message</span>')!!}
              </div>
            
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" value="{{ old('remember', 1) }}" checked>
                    로그인 기억하기
                    <small class="text-danger d-block">
                      (공용 컴퓨터에서는 사용하지 마세요!)
                    </small>
                  </label>
                </div>
              </div>
            
              <div class="form-group row m-auto">
                <button class="btn btn-primary btn-lg btn-block col-md-4 offset-md-4" type="submit">
                  로그인
                </button>
              </div>
            
              <div>
                <p class="text-center my-3">회원이 아니라면
                  <a href="{{ route('users.create') }}">
                    가입하세요.
                  </a>
                </p>
                <p class="text-center">
                  <a href="{{ route('remind.create') }}">
                    비밀번호를 잊으셨나요?
                  </a>
                </p>

                <p class="text-center">
                  <small class="help-block">
                    깃허브 로그인 사용자는 따로 회원가입하실 필요없습니다. 이 분들은 비밀번호가 없습니다.
                  </small>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection