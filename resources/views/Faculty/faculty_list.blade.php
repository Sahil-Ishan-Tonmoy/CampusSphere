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

    <x-search-filter 
        route="faculty.index"
        searchPlaceholder="Search faculty by name, department, initial or designation..."
        :departments="$Departments"
        :results="$faculties"
        entityName="faculty members"
    />

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