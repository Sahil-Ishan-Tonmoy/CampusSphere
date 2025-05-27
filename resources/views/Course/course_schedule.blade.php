<x-layout>
    <div class="container-schedule">
        <!-- Back Button -->
        <a href="{{ route('course.show', $course->course_code) }}" class="back-button-schedule">Back to Course Details</a>

        <!-- Schedule Header -->
        <div class="schedule-header">
            <div class="schedule-title-section">
                <h1 class="schedule-title">Course Schedule</h1>
                <div class="course-info-header">
                    <span class="course-name-header">{{ $course->course_name }}</span>
                    <span class="course-code-header">{{ $course->course_code }}</span>
                </div>
            </div>
            <div class="schedule-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $sections->count() }}</span>
                    <span class="stat-label">Sections</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $course->credit ?? 'N/A' }}</span>
                    <span class="stat-label">Credits</span>
                </div>
            </div>
        </div>

        @if($sections->isEmpty())
            <div class="empty-schedule">
                <div class="empty-schedule-icon">📅</div>
                <h3 class="empty-schedule-title">No Sections Available</h3>
                <p class="empty-schedule-text">There are currently no scheduled sections for this course.</p>
            </div>
        @else
            <!-- Schedule Grid -->
            <div class="schedule-grid">
                @foreach($sections as $section)
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-number">
                            Section {{ $section->section_number }}
                        </div>
                        @if($section->room)
                        <div class="section-room">
                            {{ $section->room }}
                        </div>
                        @endif
                    </div>

                    <div class="section-content">
                        <!-- Days -->
                        <div class="section-info-item">
                            <span class="section-label">Days:</span>
                            <div class="days-container">
                                @if($section->day)
                                    @foreach($section->day as $day)
                                        <span class="day-badge">{{ $day }}</span>
                                    @endforeach
                                @else
                                    <span class="day-badge">TBA</span>
                                @endif
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="section-info-item">
                            <span class="section-label">Time:</span>
                            <span class="section-time">
                                @if($section->start_time && $section->end_time)
                                    {{ \Carbon\Carbon::parse($section->start_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($section->end_time)->format('g:i A') }}
                                @else
                                    TBA
                                @endif
                            </span>
                        </div>

                        <!-- Faculty -->
                        <div class="section-info-item">
                            <span class="section-label">Instructor:</span>
                            <span class="section-faculty">
                                @if($section->faculty)
                                    <a href="{{ route('faculty.show', $section->faculty->faculty_id) }}" class="faculty-link">
                                        {{ $section->faculty->name }}
                                        <span class="faculty-initial">({{ $section->faculty->initial }})</span>
                                    </a>
                                @else
                                    <span class="no-faculty">Not Assigned</span>
                                @endif
                            </span>
                        </div>

                        
                    </div>

                    <!-- Section Actions -->
                    <div class="section-actions">
                        @if($section->faculty)
                        <a href="mailto:{{ $section->faculty->email }}" class="section-action-btn email">
                            📧 Email Instructor
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Weekly Schedule View -->
            <div class="weekly-schedule">
                <h2 class="weekly-title">Weekly Schedule Overview</h2>
                <div class="weekly-grid">
                    @php
                        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        $timeSlots = [];
                        foreach($sections as $section) {
                            if($section->start_time) {
                                $timeSlots[] = $section->start_time;
                            }
                        }
                        $timeSlots = array_unique($timeSlots);
                        sort($timeSlots);
                    @endphp

                    <div class="weekly-header">
                        <div class="time-column-header">Time</div>
                        @foreach($daysOfWeek as $day)
                            <div class="day-column-header">{{ substr($day, 0, 3) }}</div>
                        @endforeach
                    </div>

                    @foreach($timeSlots as $timeSlot)
                    <div class="weekly-row">
                        <div class="time-cell">
                            {{ \Carbon\Carbon::parse($timeSlot)->format('g:i A') }}
                        </div>
                        @foreach($daysOfWeek as $day)
                            <div class="schedule-cell">
                                @foreach($sections as $section)
                                    @if($section->start_time == $timeSlot && $section->day && in_array($day, $section->day))
                                        <div class="schedule-block">
                                            <div class="block-section">Sec {{ $section->section_number }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layout>