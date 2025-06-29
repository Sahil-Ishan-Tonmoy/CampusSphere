<x-layout>
    <div class="container-details">
        <!-- Back Button -->
        <a href="{{ route('faculty.index') }}" class="back-button">Back to Faculty List</a>

        <!-- Faculty Profile Card -->
        <div class="faculty-profile">
            <!-- Header Section -->
            <div class="profile-header">
                <div class="profile-picture-container">
                    @if($faculty->profile_picture)
                        <img src="{{ asset('storage/' . $faculty->profile_picture) }}" 
                             alt="{{ $faculty->name }}" 
                             class="profile-picture">

                    @else
                        <div class="profile-picture-placeholder">👨‍🏫</div>
                    @endif
                </div>
                <h1 class="faculty-name-details">{{ $faculty->name }}</h1>
                <div class="faculty-designation-details">{{ $faculty->designation }}</div>
                <div class="faculty-department-details">{{ $faculty->department }}</div>
            </div>

            <!-- Content Section -->
            <div class="profile-content-details">
                <div class="content-grid-details">
                    <!-- Contact Information -->
                    <div class="info-section-details">
                        <h2 class="section-title-details">Contact Information</h2>
                        
                        <div class="info-item-details">
                            <span class="info-label-details id">Faculty ID:</span>
                            <span class="info-value-details">{{ $faculty->faculty_id }}</span>
                        </div>
                        <div class="info-item-details">
                            <span class="info-label-details email">Email:</span>
                            <span class="info-value-details">
                                <a href="mailto:{{ $faculty->email }}">{{ $faculty->email }}</a>
                            </span>
                        </div>
                        @if($faculty->phone)
                        <div class="info-item-details">
                            <span class="info-label-details phone">Phone:</span>
                            <span class="info-value-details">
                                <a href="tel:{{ $faculty->phone }}">{{ $faculty->phone }}</a>
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Professional Information -->
                    <div class="info-section-details">
                        <h2 class="section-title-details">Professional Details</h2>
                        <div class="info-item-details">
                            <span class="info-label-details initial">Faculty Initial:</span>
                            <span class="info-value-details">{{ $faculty->initial }}</span>
                        </div>
                        <div class="info-item-details">
                            <span class="info-label-details designation">Designation:</span>
                            <span class="info-value-details">{{ $faculty->designation }}</span>
                        </div>
                        <div class="info-item-details">
                            <span class="info-label-details department">Department:</span>
                            <span class="info-value-details">{{ $faculty->department }}</span>
                        </div>
                        @if($faculty->experience)
                        <div class="info-item-details">
                            <span class="info-label-details">Experience:</span>
                            <span class="info-value-details">{{ $faculty->experience }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Bio Section -->
                @if($faculty->bio)
                <div class="bio-section-details">
                    <h2 class="section-title-details">Biography</h2>
                    <p class="bio-text-details">{{ $faculty->bio }}</p>
                </div>
                @endif

                <!-- Course Section with New Styling -->
                @if($faculty->sections->isNotEmpty())
                    <div class="faculty-course-showcase">
                        <h2 class="section-title-details">
                            Sections Taught
                            <span class="course-count-showcase">{{ $faculty->sections->count() }}</span>
                        </h2>
                        <ul class="course-list-showcase">
                            @foreach ($faculty->sections as $section)
                                <li class="course-item-showcase">
                                    <a href="{{ route('course.show', $section->course->course_code) }}" class="course-link-showcase">         
                                        <span class="course-code-showcase">({{ $section->course_code }})</span>
                                        <span class="section-number-showcase">Section: {{ $section->section_number }}</span>
                                        
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="faculty-course-showcase">
                        <h2 class="section-title-details">Sections Taught</h2>
                        <div class="course-empty-showcase">
                            No sections assigned to this faculty member.
                        </div>
                    </div>
                @endif


                <!-- Quick Contact Cards -->
                <div class="contact-cards-details">
                    <div class="contact-card-details">
                        <div class="contact-icon-details">📧</div>
                        <div class="contact-label-details">Email</div>
                        <a href="mailto:{{ $faculty->email }}" class="contact-value-details">Send Email</a>
                    </div>
                    @if($faculty->phone)
                    <div class="contact-card-details">
                        <div class="contact-icon-details">📞</div>
                        <div class="contact-label-details">Phone</div>
                        <a href="tel:{{ $faculty->phone }}" class="contact-value-details">Call Now</a>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>


</x-layout>

