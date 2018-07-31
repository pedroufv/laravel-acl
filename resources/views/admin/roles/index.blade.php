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
                        <div class="col-md-12">
                            <table class="table table-bordered" id="roles-table">
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
@endsection

@push('scripts')
    <script id="script">
        $(function () {
            $('#roles-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: '{{ url("admin/roles/data") }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'label', name: 'label'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "Sem dados disponíveis na tabela",
                    "info": "Exibindo _START_ até _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Exibindo 0 até 0 de 0 entradas",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Loading...",
                    "processing": "Processando...",
                    "search": "Busca:",
                    "zeroRecords": "Nenhuma resultado encontrado",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        function rolesDelete(deleteForm, e) {
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
