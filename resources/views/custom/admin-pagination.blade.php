@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
        <div class="d-flex align-items-center gap-2">
            @if ($paginator->onFirstPage())
                <button class="btn btn-sm btn-outline-secondary" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
            @endif
            
            <span class="text-muted small mx-2">
                Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            </span>
            
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <button class="btn btn-sm btn-outline-secondary" disabled>
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            @endif
        </div>
    </div>
@endif