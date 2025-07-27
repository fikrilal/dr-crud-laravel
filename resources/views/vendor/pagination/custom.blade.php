@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link">
                        <i class="bx bx-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="bx bx-chevron-left"></i>
                        <span class="d-none d-sm-inline ms-1">Previous</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bx bx-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link">
                        <span class="d-none d-sm-inline me-1">Next</span>
                        <i class="bx bx-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
.pagination .page-link {
    border: 1px solid #dee2e6;
    color: #2c5aa0;
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 2.5rem;
    background-color: #fff;
    text-decoration: none;
}

.pagination .page-link:hover {
    color: #1e3a5f;
    background-color: #f8f9fa;
    border-color: #2c5aa0;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(44, 90, 160, 0.1);
}

.pagination .page-item.active .page-link {
    background-color: #2c5aa0;
    border-color: #2c5aa0;
    color: #fff;
    box-shadow: 0 2px 4px rgba(44, 90, 160, 0.3);
}

.pagination .page-item.active .page-link:hover {
    background-color: #1e3a5f;
    border-color: #1e3a5f;
    transform: none;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.65;
    pointer-events: none;
}

.pagination .page-link i {
    font-size: 1rem;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-weight: 500;
}

@media (max-width: 576px) {
    .pagination .page-link {
        padding: 0.5rem;
        min-width: 2rem;
    }
    
    .pagination .page-link span {
        display: none !important;
    }
}
</style> 