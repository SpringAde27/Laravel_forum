@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            비밀번호 재설정 신청
            <span class="text-muted d-block">
              회원가입한 이메일로 신청하신 후, 메일박스를 확인하세요.
            </span>
          </div>
          <div class="card-body">
            <form action="{{ route('remind.store') }}" method="POST" role="form" class="form__auth">
              {!! csrf_field() !!}
          
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}" autofocus>
                {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
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