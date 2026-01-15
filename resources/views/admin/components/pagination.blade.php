@props([
    'items' => null,
    'simple' => false,
    'class' => '',
    'livewire' => false,
])

@php
    $paginator = $items ?? request()->route()->parameters() ?? null;

    if ($simple) {
        $paginationClass = 'pagination pagination-sm ' . $class;
    } else {
        $paginationClass = 'pagination ' . $class;
    }

    // Use livewire prop if explicitly set
    $isLivewire = $livewire === true || $livewire === 'true';

    // Get page name for Livewire pagination
    $pageName = method_exists($items, 'getPageName') ? $items->getPageName() : 'page';
@endphp

@if($items && method_exists($items, 'hasPages') && $items->hasPages())


    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
        </div>
        <nav aria-label="Page navigation">
            <ul class="{{ trim($paginationClass) }}">
                {{-- Previous Page Link --}}
                @if($items->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        @if($isLivewire)
                            <button type="button" class="page-link" wire:click="previousPage('{{ $pageName }}')" rel="prev" aria-label="@lang('pagination.previous')">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                        @else
                            <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    @if($page == $items->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        @if(
                            $page == 1 ||
                            $page == $items->lastPage() ||
                            ($page >= $items->currentPage() - 2 && $page <= $items->currentPage() + 2)
                        )
                            <li class="page-item">
                                @if($isLivewire)
                                    <button type="button" class="page-link" wire:click="gotoPage({{ $page }}, '{{ $pageName }}')">{{ $page }}</button>
                                @else
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            </li>
                        @elseif(
                            $page == $items->currentPage() - 3 ||
                            $page == $items->currentPage() + 3
                        )
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($items->hasMorePages())
                    <li class="page-item">
                        @if($isLivewire)
                            <button type="button" class="page-link" wire:click="nextPage('{{ $pageName }}')" rel="next" aria-label="@lang('pagination.next')">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        @else
                            <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @endif
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

