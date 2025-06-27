@props([
    'route',
    'searchPlaceholder' => 'Search...',
    'departments' => [],
    'activeDepartment' => request('department'),
    'searchQuery' => request('search'),
    'results' => null,
    'entityName' => 'items', // e.g. "courses", "faculty", "students"
])

<!-- Search and Filter Controls -->
<div class="controls-section">
    <form method="GET" action="{{ route($route) }}" class="search-filter-form">
        <div class="search-box">
            <input type="text" 
                   name="search" 
                   class="search-input" 
                   placeholder="{{ $searchPlaceholder }}"
                   value="{{ $searchQuery }}">
            <span class="search-icon">🔍</span>
        </div>

        <div class="filter-buttons">
            <button type="submit" 
                    name="department" 
                    value="" 
                    class="filter-btn {{ !$activeDepartment ? 'active' : '' }}">
                All
            </button>
            @foreach($departments as $dept)
                <button type="submit" 
                        name="department" 
                        value="{{ $dept }}"
                        class="filter-btn {{ $activeDepartment === $dept ? 'active' : '' }}">
                    {{ $dept }}
                </button>
            @endforeach
        </div>

        @if($searchQuery)
            <input type="hidden" name="search" value="{{ $searchQuery }}">
        @endif
    </form>
</div>

<!-- Results Info -->
<div class="results-info">
    <p class="results-text">
        @if($results && $results->total() > 0)
            Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} 
            of {{ $results->total() }} {{ $entityName }}
            @if($searchQuery)
                for "<strong>{{ $searchQuery }}</strong>"
            @endif
            @if($activeDepartment)
                in <strong>{{ $activeDepartment }}</strong> department
            @endif
        @else
            No {{ $entityName }} found
            @if($searchQuery || $activeDepartment)
                for your search criteria
            @endif
        @endif
    </p>

    @if($searchQuery || $activeDepartment)
        <a href="{{ route($route) }}" class="clear-filters">
            Clear all filters
        </a>
    @endif
</div>
