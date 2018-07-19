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
                        <div class="col-md-12">
                            <table class="table table-bordered" id="users-table">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th>@lang('general.name')</th>
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
            ajax: '{{ url("admin/users/data") }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "Sem dados disponíveis na tabela",
                "info":           "Exibindo _START_ até _END_ de _TOTAL_ entradas",
                "infoEmpty":      "Exibindo 0 até 0 de 0 entradas",
                "infoFiltered":   "(filtered from _MAX_ total entries)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Loading...",
                "processing":     "Processando...",
                "search":         "Busca:",
                "zeroRecords":    "Nenhuma resultado encontrado",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
    });
</script>
<script type="text/javascript">
    function usersDelete(deleteForm, e) {
        e.preventDefault();
        swal({
                title: "Tem certeza que deseja excluir?",
                text: "Não será possível recuperar os dados deste usuário!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não!",
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $(deleteForm).submit();
                    return true;
                }
            });
    }
</script>
@endpush
