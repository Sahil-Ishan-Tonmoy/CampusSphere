<x-layout>
    <h1>Faculty Details</h1>
    <ul>
    @foreach($faculties as $faculty)
        <li><p>Faculty Name: {{$faculty['Name']}}  |    <a href="/faculty_list/{{$faculty['id']}}" class:"btn">View Details</a></p></li>
    @endforeach
        
    </ul>  
    
</x-layout>