<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class Student_Controller extends Controller
{
    public function index(Request $request)
{
    $query = Student::query();

    // Apply search filters
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('student_id', 'like', "%{$search}%");
        });
    }

    // Apply department filter
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }
    
    // Get paginated results
    $students = $query->paginate(9)->withQueryString();
    
    // Get departments for filter
    $departments = Student::distinct()->pluck('department');
    $enrolledStudentsCount = Student::whereNotNull('courses')->count();
    $totalStudentsCount = Student::count();

   return view('Student.student_list', [
        'students' => $students,
        'departments' => $departments,
        'enrolledStudentsCount' => $enrolledStudentsCount,
        'totalStudentsCount' => $totalStudentsCount,
    ]);
}
}
