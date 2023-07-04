@extends('layouts/blankLayout')

@section('title', 'Reset Password')

@section('content')
    @include('elements.helpers.notification')
    <div class="container mt-5">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-re-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Your Password?</h1>
                                    </div>
                                    <form class="user" action="{{ route('reset-password.post') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}" />
                                        <div class="form-group {{ $errors->has('password') ? 'invalid' : '' }}">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="New Password" name="password">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('password') ? 'invalid' : '' }}">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Re-New Password" name="re-password">
                                            @if ($errors->has('re-password'))
                                                <span class="text-danger">{{ $errors->first('re-password') }}</span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
