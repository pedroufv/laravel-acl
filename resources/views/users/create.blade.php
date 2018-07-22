@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-header">
                    <h4 class="card-title">@lang('admin.users.create')</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.users.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('general.name')</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}" name="name" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('general.email')</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}" name="email" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-md-4 col-form-label text-md-right">@lang('admin.roles.index')</label>
                            <div class="col-md-6">
                                @foreach($roles as $role)
                                    <div class="col-md-4">
                                        <input type="checkbox" class="form-check-input" name="roles[]" id="{{ $role->id }}" value="{{ $role->id }}">
                                        <label class="form-check-label" for="exampleCheck1">{{ $role->label }}</label>
                                    </div>
                                @endforeach
                                @if ($errors->has('roles'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('roles') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('user.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('user.password_confirm')</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('general.save')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
