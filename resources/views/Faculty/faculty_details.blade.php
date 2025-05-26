<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CampusSphere</title>
</head>
<body>
   
    <h1>Faculty Details</h1>
        <p>Faculty Id is {{$id}}</p>
        @if($id==22301612)
            <p>Duke Dennis</p>
        @endif
        
        
    
</body>
</html>