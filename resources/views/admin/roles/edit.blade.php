@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-12">
                <div class="card-header">
                    <h4 class="card-title">@lang('admin.roles.edit')</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.roles.update', ['id' => $role->id]) }}" aria-label="@lang('admin.roles.edit')">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('general.name')</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $role->name }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-md-4 col-form-label text-md-right">@lang('general.label')</label>
                            <div class="col-md-6">
                                <input id="label" type="label" class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }}" name="label" value="{{ old('label') ? old('label') : $role->label }}" required>
                                @if ($errors->has('label'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('label') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="label" class="col-md-4 col-form-label text-md-right">@lang('general.permissions')</label>
                            <div class="col-md-8">
                                @foreach($permissionsGrouped as $key => $grouped)
                                    <span class="font-weight-bold" style="margin-left: -5px;">{{ $key }}</span>
                                    <div class="col-md-12" style="padding-bottom: 10px">
                                    @foreach($grouped as $permission)
                                        <input type="checkbox" class="form-check-input" name="permissions[]" id="{{ $permission->id }}" @if(old("permission")) {{ in_array($permission->id, old("permissions")) ? 'checked="checked"' : ''}} @else {{$permission->check ? 'checked="checked"' : '' }} @endif value="{{ $permission->id }}">
                                        <label class="form-check-label" style="min-width: 18%">@lang('permissions.'.$permission->nick)</label>
                                    @endforeach
                                    </div>
                                @endforeach
                                @if ($errors->has('permissions'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('permissions') }}</strong>
                                    </span>
                                @endif
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
