@extends('layouts.app')

@section('content')
<div class="container animated fadeIn animation-delay-5">
    <div class="login-container">
        <div class="panel-container center-block">
            <div class="panel panel-default login-panel">
                <div class="panel-heading">
                    <i class="fa fa-user-circle-o"></i>
                    Login
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <div class="email-container">
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control" name="email"
                                           placeholder="Your Email Address" aria-label="Please enter your email"
                                           value="{{ old('email') }}" required autofocus>
                                    <span class="input-group-addon"><i class="fa  fa-at"></i> </span>
                                </div>


                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <div class="password-container">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control" name="password"
                                           placeholder="Enter your password" aria-label="Please enter your password" required>
                                    <span class="input-group-addon"><i class="fa  fa-lock"></i> </span>
                                </div>



                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="remember-container">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default btn-danger btn-block login-btn">
                                    Login
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                                <a class="btn btn-link" href="{{ url('/login/github') }}">
                                    <i class="fa fa-github-square fa-3x"
                                       data-toggle="popover" data-placement="top" title="Github Login"
                                       data-content="Use Github to login to and automatically create a new account."></i>
                                </a>
                                <a class="btn btn-link" href="{{ url('/login/facebook') }}" disabled>
                                    <i class="fa fa-facebook-square fa-3x"
                                       data-toggle="popover" data-placement="bottom" title="Facebook Login"
                                       data-content="Use Facebook to login to and automatically create a new account."></i>
                                </a>
                                <a class="btn btn-link" href="{{ url('/login/google') }}" disabled>
                                    <i class="fa fa-google-plus-square fa-3x"
                                       data-toggle="popover" data-placement="top" title="Google Login"
                                       data-content="Use Google+ to login to and automatically create a new account."></i>
                                </a>
                                <a class="btn btn-link" href="{{ url('/login/twitter') }}" disabled>
                                    <i class="fa fa-twitter-square fa-3x"
                                       data-toggle="popover" data-placement="bottom" title="Twitter Login"
                                       data-content="Use Twitter to login and automatically create a new account."></i>
                                </a>
                                <a class="btn btn-link" href="{{ url('/login/linkedin') }}" disabled>
                                    <i class="fa fa-linkedin-square fa-3x"
                                       data-toggle="popover" data-placement="top" title="LinkedIn Login"
                                       data-content="Use LinkedIn to login and automatically create a new account."></i>
                                </a>
                                <a class="btn btn-link" href="{{ url('/login/bitbucket') }}" disabled>
                                    <i class="fa fa-bitbucket-square fa-3x"
                                       data-toggle="popover" data-placement="bottom" title="Bitbucket Login"
                                       data-content="Use Bitbucket to login to and automatically create a new account."></i>
                                </a>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="btn btn-link center-block" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
