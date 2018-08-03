@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">@lang('admin.users.index')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <span class='fa fa-plus'></span>
                            </a>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12 table-responsive-md">
                            <ul class="nav nav-tabs justify-content-end">
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#all-users">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#only-trashed">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="all-users">
                                    <table class="table table-bordered table-hover" id="users-table">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.username')</th>
                                            <th>@lang('general.email')</th>
                                            <th>@lang('general.created_at')</th>
                                            <th>@lang('general.updated_at')</th>
                                            <th style="width: 10%;">@lang('general.actions')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="only-trashed">
                                    <table class="table table-bordered table-hover" id="users-trashed-table">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.username')</th>
                                            <th>@lang('general.email')</th>
                                            <th>@lang('general.created_at')</th>
                                            <th>@lang('general.updated_at')</th>
                                            <th style="width: 10%;">@lang('general.actions')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script id="script">
        $(function () {
            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust().responsive.recalc();
            } );

            $('#users-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                order: [ [0, 'desc'] ],
                ajax: {
                    url: 'users/data'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#users-trashed-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: 'users/data',
                    data: {onlyTrashed: true}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
    <script type="text/javascript">
        function usersDelete(deleteForm, e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $(deleteForm).submit();
                }
            });
        }
    </script>
@endpush
