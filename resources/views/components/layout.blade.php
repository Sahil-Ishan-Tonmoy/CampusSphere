<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <a href="/faculty" class="nav-link {{ request()->is('faculty') ? 'active' : '' }}">Faculty List</a>
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
    <main class= "container">
        {{ $slot }}

    </main>
    
</body>
</html>