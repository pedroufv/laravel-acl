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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script id="script">
        $(function () {
            $('#users-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: '{{ url("admin/users/data") }}',
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
                text: "Once deleted, you will not be able to recover this!",
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
