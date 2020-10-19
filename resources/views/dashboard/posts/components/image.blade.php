@php
$imageClasses = [];

if (data_get($block, 'data.stretched') && data_get($block, 'data.stretched') == 'true') {
    $imageClasses[] = 'img-fluid';
}

if (data_get($block, 'data.withBorder') && data_get($block, 'data.withBorder') == 'true') {
    $imageClasses[] = 'img-thumbnail';
}
@endphp

<figure class="figure">
    <img src="{{ data_get($block, 'data.file.url') }}" class="figure-img rounded {{ implode(' ', $imageClasses) }}" alt="{{ data_get($block, 'data.caption') }}">
    <figcaption class="figure-caption text-center">{{ data_get($block, 'data.caption') }}</figcaption>
</figure>
