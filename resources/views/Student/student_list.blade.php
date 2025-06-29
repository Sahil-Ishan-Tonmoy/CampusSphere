<x-layout>

    <div class="page-header">
        <h1 class="page-title">Student Directory</h1>
        <p class="page-subtitle">Browse our talented student community</p>
    </div>

    <!-- Stats Section (dynamic with paginated data) -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-number">{{ $totalStudentsCount }}</div>
            <div class="stat-label">Total Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ count($departments) }}</div>
            <div class="stat-label">Departments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $enrolledStudentsCount }}</div>
            <div class="stat-label">Enrolled Students</div>
        </div>
    </div>

    <x-search-filter 
        route="student.index"
        searchPlaceholder="Search students by name, ID, department or email..."
        :departments="$departments"
        :results="$students"
        entityName="students"
    />


    @if($students->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">👨‍🎓</div>
            <h3 class="empty-state-title">No Students Available</h3>
            <p class="empty-state-text">
                @if(request('search') || request('department'))
                    No students match your search criteria. Try adjusting your filters.
                @else
                    There are currently no students in the system.
                @endif
            </p>
            @if(request('search') || request('department'))
                <a href="{{ route('student.index') }}" class="btn btn-primary" style="margin-top: 20px;">
                    View All Students
                </a>
            @endif
        </div>
    @else
        <ul class="student-grid">
            @foreach($students as $student)
            <li>
                <div class="student-card">
                    <div class="student-avatar">
                        @if($student->profile_picture)
                            <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->name }}" class="student-image">
                        @else
                            <div class="student-initials">{{ substr($student->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="student-info">
                        <div class="student-department">
                            {{ $student->department }}
                        </div>
                        <h3 class="student-name">{{ $student->name }}</h3>
                        <div class="student-id">ID: {{ $student->student_id }}</div>
                       <div class="student-courses">
                            @if($student->courses)
                                @php
                                    $courses = json_decode($student->courses, true); // decode as array
                                @endphp
                                <span class="course-count">{{ count($courses) }} Courses</span>
                            @else
                                <span class="course-count">No Courses</span>
                            @endif
                        </div>

                    </div>
                    <div class="student-actions">
                        <a href="{{ route('student.show', $student->student_id) }}" class="btn-student-details">
                            View Profile
                        </a>
                        <a href="mailto:{{ $student->email }}" class="btn-student-contact">
                            Contact
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        
        <div class="pagination">
            {{ $students->links() }}
            <div class="pagination-compact-info">
                Page <span class="current-page">{{ $students->currentPage() }}</span> of {{ $students->lastPage() }}
            </div>
        </div>
    @endif
</x-layout>