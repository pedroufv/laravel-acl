@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">@lang('admin.roles.show')
                        @if($role->trashed())
                            <span class="badge badge-pill badge-danger">@lang('general.trash')</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.name')</label>
                        <span>{{ $role->name }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.label')</label>
                        <span>{{ $role->label }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.permissions')</label>
                        <div class="col-md-8">
                            @foreach($permissionsGrouped as $key => $grouped)
                                <span class="font-weight-bold" style="margin-left: -15px;">{{ $key }}</span>
                                <div class="col-md-12" style="padding-bottom: 10px">
                                    @foreach($grouped as $permission)
                                        <input type="checkbox" class="form-check-input" name="permissions[]" readonly onclick="return false" onkeydown="return false" id="{{ $permission->id }}" {{$permission->check ? 'checked="checked"' : '' }} value="{{ $permission->id }}">
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
                </div>
            </div>
        </div>
    </div>
@endsection
