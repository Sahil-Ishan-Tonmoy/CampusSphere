<x-layout>
    <div class="page-header">
        <h1 class="page-title">Faculty Directory</h1>
        <p class="page-subtitle">Meet our distinguished faculty members</p>
    </div>

    <!-- Stats Section (you can make this dynamic) -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-number">{{ count($faculties) }}</div>
            <div class="stat-label">Total Faculty</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $faculties->pluck('Department')->unique()->count() }}</div>
            <div class="stat-label">Departments</div>
        </div>
        
    
    </div>

    <!-- Search and Filter Controls -->
    <div class="controls-section">
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search faculty by name or department...">
            <span class="search-icon">🔍</span>
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active">All</button>
            @foreach(collect($faculties)->pluck('Department')->unique() as $dept)
                <button class="filter-btn">{{ $dept }}</button>
            @endforeach

        </div>
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
                        {{ $faculty['Department'] }}
                    </div>
                    <h3 class="faculty-name">{{ $faculty['Name'] }}</h3>
                    <div class="faculty-id">Faculty ID: {{ $faculty['id'] }}</div>
                </div>
                <a href="/faculty_list/{{ $faculty['id'] }}" class="btn btn-primary">View Details</a>
            </div>
        </li>
        @endforeach
    </ul>
    @endif
</x-layout>