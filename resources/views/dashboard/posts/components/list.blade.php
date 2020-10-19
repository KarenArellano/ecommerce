@php
$tag = Str::is('ordered', data_get($block, 'data.style')) ? 'ol' : 'ul';
@endphp

{!! "<$tag><li>" . implode("</li><li>", data_get($block, 'data.items')) . "</li></$tag>" !!}
