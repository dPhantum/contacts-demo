@extends('layouts.app')

@section('content')
<div class="container animated fadeIn animation-delay-5">
    <div class="login-container">
        <div class="panel-container center-block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-pencil-square"></i>
                    Register
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>

                            <div class="name-container">
                                <div class="input-group">
                                    <input id="name" type="text" class="form-control" name="name"
                                           placeholder="Your Email Name" aria-label="Please enter your name"
                                           value="{{ old('name') }}" required autofocus>
                                    <span class="input-group-addon"><i class="fa  fa-user"></i> </span>
                                </div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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
                            <label for="password-confirm" class="control-label">Confirm Password</label>

                            <div class="confirm-container">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                           placeholder="Enter your password again" aria-label="Please enter your password again"
                                           name="password_confirmation" required>
                                    <span class="input-group-addon"><i class="fa  fa-lock"></i> </span>
                                </div>


                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
