@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            비밀번호 재설정
            <span class="text-muted d-block">
              회원가입했던 이메일을 입력하고, 새로운 비밀번호를 입력하세요.
            </span>
          </div>
          <div class="card-body">
            <form action="{{ route('reset.store') }}" method="POST" role="form" class="form__auth">
              {!! csrf_field() !!}
          
              {{-- URL로 받은 {token}값을 다시 숨은 필드로 재설정 컨트롤러에 전송 --}}
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}" autofocus>
                {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="새로운 비밀번호">
                {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인">
                {!! $errors->first('password_confirmation', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="row justify-content-center m-auto">
                <button class="btn btn-primary btn-lg btn-block col-lg-6" type="submit">
                  비밀번호 재설정 메일 발송
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection