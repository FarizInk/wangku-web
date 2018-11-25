@extends('layouts.blank')

@section('title', 'Registrasi')

@section('content')
    <div class="row min-h-fullscreen center-vh p-20 m-0">
      <div class="col-12">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
          <h5 class="text-uppercase">Registrasi</h5>
          <br>

          <form class="form-type-material" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-input">
                  <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">
                  <label>Nama</label>
                  @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-input">
                  <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" value="{{ old('username') }}">
                  <label>Username</label>
                  @if ($errors->has('username'))
                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-input">
                  <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                  <label>Email</label>
                  @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-input">
                  <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">
                  <label>Password</label>
                  @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-input">
                  <input type="password" class="form-control" name="password_confirmation">
                  <label>Konfirmasi Password</label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button class="btn btn-bold btn-block btn-primary" type="submit">Registrasi</button>
            </div>
          </form>
      </div>
    </div>
@endsection
