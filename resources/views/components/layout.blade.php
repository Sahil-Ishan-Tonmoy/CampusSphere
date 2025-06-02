<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CampusSphere</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    
</head>
<body>
    <header>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="nav-logo">
                <div class="nav-logo-icon">🎓</div>
                CampusSphere
            </a>
            
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faculty.index')}}" class="nav-link {{ request()->is('faculty') ? 'active' : '' }}">Faculty List</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student.index')}}" class="nav-link {{ request()->is('student') ? 'active' : '' }}">Student List</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('course.index')}}" class="nav-link {{ request()->is('course') ? 'active' : '' }}">Course List</a>
                </li>

                <li class="nav-item">
                    <x-invite-button :inviteUrl="url()->current()" />
                </li>
                <!-- Add more navigation items as needed -->
            </ul>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>
</header>
    <main class="container">
        {{ $slot }}
    </main>
    
    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');
            
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', function() {
                    navToggle.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }
            
            // Initialize results info display if search or filter is active
            const resultsInfo = document.querySelector('.results-info');
            if (resultsInfo && (window.location.search.includes('search=') || window.location.search.includes('department='))) {
                resultsInfo.classList.add('show');
            }
        });
    </script>
</body>
</html>
