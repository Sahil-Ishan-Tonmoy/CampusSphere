<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CampusSphere</title>
</head>
<body>
    <h1>Faculty Details</h1>
    <ul>
    @foreach($faculties as $faculty)
        <li><p>Faculty Name: {{$faculty['Name']}}  |    <a href="/faculty_list/{{$faculty['id']}}" class:"btn">View Details</a></p></li>
    @endforeach
        
    </ul>  
    
</body>
</html>