<?php

namespace App\Http\Controllers;

use App\Models\Course;

use App\Models\Faculty;
use Illuminate\Http\Request;

class Course_Controller extends Controller
{
   public function index()
{
    $courses = Course::orderBy('name', 'asc')->paginate(6);

    $Departments = Faculty::select('department')->distinct()->pluck('department')->toArray();

    
    if (empty($Departments)) {
        $Departments = ['No departments found.'];
    }

    if ($courses->isEmpty()) {
        return view('Course.course_list', [
            'message' => 'No Course members found.',
            'Departments' => $Departments
        ]);
    }

    return view('Course.course_list', [
        'courses' => $courses,
        'Departments' => $Departments
    ]);
}

        public function show($course_code)
    {
        $course = Course::where('course_code', $course_code)->first();

        if (!$course) {
            return redirect()->route('course.index')->with('error', 'Course not found.');
        }
       $coordinator = $course->coordinator;



        return view('Course.course_details', ['course' => $course, 'coordinator' => $coordinator]);
    }

}
