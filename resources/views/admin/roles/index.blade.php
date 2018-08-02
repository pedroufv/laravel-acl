@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">@lang('admin.roles.index')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                <span class='fa fa-plus'></span>
                            </a>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12 table-responsive-md">
                            <ul class="nav nav-tabs justify-content-end">
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" role="tab" href="#all-roles">
                                        <icon class="fa fa-bars"></icon>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#only-trashed">
                                        <icon class="fa fa-trash"></icon>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="all-roles">
                                    <table class="table table-bordered table-hover" id="roles-table">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.label')</th>
                                            <th style="width: 10%;">@lang('general.actions')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="only-trashed">
                                    <table class="table table-bordered table-hover" id="roles-trashed-table">
                                        <thead>
                                        <tr>
                                            <th style="width: 5%;">ID</th>
                                            <th>@lang('general.name')</th>
                                            <th>@lang('general.label')</th>
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
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust().responsive.recalc();;
            } );

            $('#roles-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                order: [ [0, 'desc'] ],
                ajax: {
                    url: 'roles/data'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'label', name: 'label'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#roles-trashed-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: 'roles/data',
                    data: {onlyTrashed: true}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'label', name: 'label'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
    <script type="text/javascript">
        function rolesDelete(deleteForm, e) {
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
