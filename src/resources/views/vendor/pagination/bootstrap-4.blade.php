@if ($paginator->hasPages())
  <nav>
    <ul class="pagination justify-content-end">
      {{-- First Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
          <span class="page-link" aria-hidden="true">«</span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')">«</a>
        </li>
      @endif

      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <span class="page-link" aria-hidden="true">‹</span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
            aria-label="@lang('pagination.previous')">‹</a>
        </li>
      @endif

      {{-- Current Page --}}
      <li class="page-item active" aria-current="page"><span class="page-link">{{ $paginator->currentPage() }}</span>
      </li>

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
            aria-label="@lang('pagination.next')">›</a>
        </li>
      @else
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
          <span class="page-link" aria-hidden="true">›</span>
        </li>
      @endif

      {{-- Last Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="@lang('pagination.last')">»</a>
        </li>
      @else
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
          <span class="page-link" aria-hidden="true">»</span>
        </li>
      @endif
    </ul>
  </nav>
@endif
