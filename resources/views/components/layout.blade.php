<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusSphere</title>
</head>
<body>
    <header>
        <nav>
          
            <p><a href="/">Home</a>     <a href="/faculty_list">Faculty List</a></p>
          
        </nav>
    </header>
    <main class= "container">
        {{ $slot }}

    </main>
    
</body>
</html>