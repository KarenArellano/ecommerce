@if ($paginator->hasPages())
<nav>
    <ul class="pagination pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="page-link px-3" aria-hidden="true">
                <i class="ti-angle-double-left"></i>
            </span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link px-3" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                <i class="ti-angle-double-left"></i>
            </a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link px-3">{{ $element }}</span>
        </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active" aria-current="page">
            <span class="page-link px-3">{{ $page }}</span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link px-3" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link px-3" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                <i class="ti-angle-double-right"></i>
            </a>
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="page-link px-3" aria-hidden="true">
                <i class="ti-angle-double-right"></i>
            </span>
        </li>
        @endif
    </ul>
</nav>
@endif
