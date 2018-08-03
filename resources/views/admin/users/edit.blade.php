@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-12">
                <div class="card-header">
                    <h4 class="card-title">@lang('admin.users.edit')</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', ['id' => $user->id]) }}" aria-label="@lang('admin.users.edit')">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('general.name')</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $user->name }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">@lang('general.username')</label>
                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') ? old('username') : $user->username }}" required>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('general.email')</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-md-4 col-form-label text-md-right">@lang('general.roles')</label>
                            <div class="col-md-6" style="padding-top:5px">
                                @foreach($roles as $role)
                                    <div class="col-md-6 float-left">
                                        <input type="checkbox" class="form-check-input{{ $errors->has('roles') ? ' is-invalid' : '' }}" name="roles[]" id="{{ $role->id }}" @if(old("roles")) {{ in_array($role->id, old("roles")) ? 'checked="checked"' : ''}} @else {{$role->check ? 'checked="checked"' : '' }} @endif value="{{ $role->id }}">
                                        <label class="form-check-label">{{ $role->label }}</label>
                                    </div>
                                @endforeach
                                @if ($errors->has('roles'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('roles') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('user.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('user.password_confirm')</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
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
