@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">@lang('admin.users.show')
                        @if($user->trashed())
                            <span class="badge badge-pill badge-danger">@lang('general.trash')</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.name')</label>
                        <span>{{ $user->name }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.username')</label>
                        <span>{{ $user->username }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.email')</label>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.roles')</label>
                        <span>{{ $user->roles->implode('name',', ') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
