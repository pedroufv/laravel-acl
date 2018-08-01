@can("admin.$table.edit", $entity->id)
<a href="{{ route("admin.$table.edit",['id' =>  $entity->id]) }}" class="btn btn-sm btn-primary">
    <i class='fa fa-pencil'></i>
</a>
@endcan

@can("admin.$table.destroy", $entity->id)
<form onclick="return {{ $table }}Delete(this, event)"
      method="POST"
      id="{{ $table }}-destroy"
      style="display: inline; color: #3097d1;"
      class="form-horizontal"
      role="form"
      action="{{ route("admin.$table.destroy", ['id' => $entity->id]) }}">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="DELETE">
    <button type="submit" class="btn btn-sm btn-primary">
        <i class="fa {{!$entity->trashed() ? 'fa-trash' : 'fa-recycle'}}"></i>
    </button>
</form>
@endcan
