<x-layout>
    <div class="container-course-details">
        <!-- Back Button -->
        <a href="{{ route('course.index') }}" class="back-button-course">Back to Course List</a>
        <h1 class="course-details-title">{{ $coordinator->name }} </h1>

        <!-- Course Profile Card -->
        <div class="course-profile">
            <!-- Header Section -->
            <div class="course-header-section">
                <div class="course-icon-container">
                    <div class="course-icon-placeholder">📚</div>
                </div>
                <h1 class="course-name-details">{{ $course->course_name }}</h1>
                <div class="course-code-details">{{ $course->course_code }}</div>
                <div class="course-department-details">{{ $course->department }}</div>
            </div>

            <!-- Content Section -->
            <div class="course-content-details">
                <div class="course-grid-details">
                    <!-- Course Information -->
                    <div class="course-info-section-details">
                        <h2 class="course-section-title-details">Course Information</h2>
                        
                        <div class="course-info-item-details">
                            <span class="course-info-label-details code">Course Code:</span>
                            <span class="course-info-value-details">{{ $course->course_code }}</span>
                        </div>
                        <div class="course-info-item-details">
                            <span class="course-info-label-details department">Department:</span>
                            <span class="course-info-value-details">{{ $course->department }}</span>
                        </div>
                        <div class="course-info-item-details">
                            <span class="course-info-label-details credit">Credits:</span>
                            <span class="course-info-value-details">{{ $course->credit ?? 'N/A' }}</span>
                        </div>
                        
                    </div>

                    <!-- Coordinator Information -->
                    <div class="course-info-section-details">
                        <h2 class="course-section-title-details">Course Coordinator</h2>
                        @if($coordinator)
                        <div class="course-info-item-details">
                            <span class="course-info-label-details coordinator">Name:</span>
                            <span class="course-info-value-details">{{ $coordinator->name }}</span>
                        </div>
                        <div class="course-info-item-details">
                            <span class="course-info-label-details designation">Designation:</span>
                            <span class="course-info-value-details">{{ $coordinator->designation }}</span>
                        </div>
                        <div class="course-info-item-details">
                            <span class="course-info-label-details email">Email:</span>
                            <span class="course-info-value-details">
                                <a href="mailto:{{ $coordinator->email }}">{{ $coordinator->email }}</a>
                            </span>
                        </div>
                        
                        @else
                        <div class="course-info-item-details">
                            <span class="course-info-value-details">No coordinator assigned</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Description Section -->
                @if($course->description)
                <div class="course-description-section-details">
                    <h2 class="course-section-title-details">Course Description</h2>
                    <p class="course-description-text-details">{{ $course->description }}</p>
                </div>
                @endif

                <!-- Quick Action Cards -->
                <div class="course-action-cards-details">
                    <div class="course-action-card-details">
                        <div class="course-action-icon-details">📋</div>
                        <div class="course-action-label-details">Syllabus</div>
                        <a href="#" class="course-action-value-details">View Syllabus</a>
                    </div>
                    @if($coordinator)
                    <div class="course-action-card-details">
                        <div class="course-action-icon-details">👨‍🏫</div>
                        <div class="course-action-label-details">Coordinator</div>
                        <a href="{{ route('faculty.show', $coordinator->faculty_id) }}" class="course-action-value-details">Contact Coordinator</a>
                    </div>
                    @endif
                    <div class="course-action-card-details">
                        <div class="course-action-icon-details">📅</div>
                        <div class="course-action-label-details">Schedule</div>
                        <a href="#" class="course-action-value-details">View Schedule</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>