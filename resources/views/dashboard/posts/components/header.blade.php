@php
$tag = 'h'.data_get($block,'data.level', 'h2');
@endphp

<{{ $tag }}>{{ data_get($block, 'data.text') }}</{{ $tag }}>
