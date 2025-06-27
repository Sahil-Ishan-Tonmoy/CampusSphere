<x-layout>
    <div class="page-header">
        <h1 class="page-title">Course Directory</h1>
        <p class="page-subtitle">Explore our comprehensive course catalog</p>
    </div>

   <!-- Stats Section (dynamic with paginated data) -->
<div class="stats-section">
    <div class="stat-card">
        <div class="stat-number">{{ $courses->total() }}</div>
        <div class="stat-label">Total Courses</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ count($Departments) }}</div>
        <div class="stat-label">Departments</div>
    </div>
    
</div>

<x-search-filter 
    route="course.index"
    searchPlaceholder="Search courses by name, code, or department..."
    :departments="$Departments"
    :results="$courses"
    entityName="courses"
/>


@if($courses->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">📚</div>
        <h3 class="empty-state-title">No Courses Available</h3>
        <p class="empty-state-text">There are currently no courses matching your criteria.</p>
    </div>
@else
    <ul class="course-grid">
        @foreach($courses as $course)
        <li>
            <div class="course-card">
                <div class="course-header">
                    <div class="course-department">
                        {{ $course->department }}
                    </div>
                    <div class="course-status {{ strtolower($course->status ?? 'active') }}">
                        {{ ucfirst($course->status ?? 'Active') }}
                    </div>
                </div>
                <div class="course-info">
                    <h3 class="course-title">{{ $course->course_name }}</h3>
                    <div class="course-code">Course Code: {{ $course->course_code }}</div>
                    <div class="course-credits">Credits: {{ $course->credit ?? 'N/A' }}</div>
                    @if($course->semester)
                        <div class="course-semester">Semester: {{ $course->semester }}</div>
                    @endif
                </div>
                <div class="course-actions">
                    <a href="{{ route('course.show', $course->course_code) }}" class="btn btn-primary">
                        View Details
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    
    <div class="pagination">
        {{ $courses->links() }}
        <div class="pagination-compact-info">
            Page <span class="current-page">{{ $courses->currentPage() }}</span> of {{ $courses->lastPage() }}
        </div>
    </div>
@endif

</x-layout>