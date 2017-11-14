@extends('layouts.app')

@section('content')
<div class="container">
    <div class="animated fadeIn">
        <div class="panel-container center-block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-lock"></i>
                    Request Password Reset
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <div class="email-field-container">

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

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-block">
                                    Send Password Reset Link
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
