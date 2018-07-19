@foreach($items as $item)
    @if($item->link)
      <a@lm-attrs($item->link) class="dropdown-item" @lm-endattrs href="{!! $item->url() !!}">
        {!! $item->title !!}
      </a>
    @else
      {!! $item->title !!}
    @endif
    @if($item->hasChildren())
      <div class="dropdown-menu">
        @include(config('laravel-menu.views.bootstrap-dropdown-items'), array('items' => $item->children()))
      </div>
    @endif
@endforeach
