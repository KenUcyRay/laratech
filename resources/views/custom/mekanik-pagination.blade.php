<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted small">
        @if($paginator->total() > 0)
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        @else
            Showing 0 to 0 of 0 results
        @endif
    </div>
    <div class="d-flex align-items-center gap-2">
        @if ($paginator->onFirstPage())
            <button class="btn btn-sm btn-outline-secondary" disabled>
                <i class="fas fa-chevron-left"></i> Previous
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-chevron-left"></i> Previous
            </a>
        @endif
        
        <span class="text-muted small mx-2">
            Page {{ $paginator->currentPage() }} of {{ max($paginator->lastPage(), 1) }}
        </span>
        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline-warning">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="btn btn-sm btn-outline-secondary" disabled>
                Next <i class="fas fa-chevron-right"></i>
            </button>
        @endif
    </div>
</div>