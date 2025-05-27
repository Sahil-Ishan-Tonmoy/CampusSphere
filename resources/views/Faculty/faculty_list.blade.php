<x-layout>
    <div class="page-header">
        <h1 class="page-title">Faculty Directory</h1>
        <p class="page-subtitle">Meet our distinguished faculty members</p>
    </div>

   <!-- Stats Section (dynamic with paginated data) -->
<div class="stats-section">
    <div class="stat-card">
        <div class="stat-number">{{ $faculties->total() }}</div>
        <div class="stat-label">Total Faculty</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{  count($Departments)}}</div>
        <div class="stat-label">Departments</div>
    </div>

    
</div>

        <!-- Search and Filter Controls -->
        <div class="controls-section">
            <form method="GET" action="{{ route('faculty.index') }}" class="search-filter-form">
                <div class="search-box">
                    <input type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Search faculty by name, department, initial or designation..."
                        value="{{ request('search') }}">
                    <span class="search-icon">🔍</span>
                </div>
                <div class="filter-buttons">
                    <button type="submit" 
                            name="department" 
                            value="" 
                            class="filter-btn {{ !request('department') ? 'active' : '' }}">
                        All
                    </button>
                    @foreach($Departments as $Department)
                        <button type="submit" 
                                name="department" 
                                value="{{ $Department }}"
                                class="filter-btn {{ request('department') === $Department ? 'active' : '' }}">
                            {{ $Department }}
                        </button>
                    @endforeach
                </div>
            </form>
        </div>
        
        <!-- Hidden field to preserve search when filtering -->
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
    </form>
</div>

<!-- Results Info -->
<div class="results-info">
    <p class="results-text">
        @if($faculties->total() > 0)
            @if(request('search'))
                for "<strong>{{ request('search') }}</strong>"
            @endif
            @if(request('department'))
                in <strong>{{ request('department') }}</strong> department
            @endif
        @else
            No faculty members found
            @if(request('search') || request('department'))
                for your search criteria
            @endif
        @endif
    </p>
    
    @if(request('search') || request('department'))
        <a href="{{ route('faculty.index') }}" class="clear-filters">
            Clear all filters
        </a>
    @endif
</div>
    @if(empty($faculties))
    <p>No faculty data available.</p>
    @else
    <ul class="faculty-grid">
        @foreach($faculties as $faculty)
        <li>
            <div class="faculty-card">
                <div class="faculty-info">
                    <div class="faculty-department ">
                        {{ $faculty['department'] }}
                    </div>
                    <h3 class="faculty-name">{{ $faculty['name'] }}</h3>
                    <div class="faculty-id">ID: {{ $faculty['faculty_id'] }}</div>
                    <div class="faculty-id">Initial: {{ $faculty['initial'] }}</div>
                </div>
                <a href="{{ route('faculty.show', $faculty->faculty_id)}}" class="btn btn-primary">View Details</a>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="pagination">
        {{ $faculties->links() }}
        <div class="pagination-compact-info">
            Page <span class="current-page">{{ $faculties->currentPage() }}</span> of {{ $faculties->lastPage() }}
        </div>
    </div>
    @endif

    

</x-layout>