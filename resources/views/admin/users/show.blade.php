@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header row">
                    <h3 class="card-title col-md-10">@lang('admin.users.show')
                        @if($entity->trashed())
                            <span class="badge badge-pill badge-danger">@lang('general.trash')</span>
                        @endif
                    </h3>
                    <div class="col-md-2">
                        @include('admin.partials.actions')
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.name')</label>
                        <span>{{ $entity->name }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.username')</label>
                        <span>{{ $entity->username }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.email')</label>
                        <span>{{ $entity->email }}</span>
                    </div>
                    <div class="row">
                        <label class="col-md-3 font-weight-bold">@lang('general.roles')</label>
                        <span>{{ $entity->roles->implode('name',', ') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
