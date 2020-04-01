@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">회원가입</div>
          <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" role="form" class="form__auth">
              {!! csrf_field() !!}
          
              <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <input type="text" name="name" class="form-control" placeholder="이름" value="{{ old('name') }}"/>
                {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="이메일" value="{{ old('email') }}"/>
                {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="비밀번호"/>
                {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인" />
                {!! $errors->first('password_confirmation', '<span class="form-error">:message</span>') !!}
              </div>
          
              <div class="form-group row">
                <button class="btn btn-primary btn-lg btn-block col-md-4 offset-md-4" type="submit">
                  가입하기
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

