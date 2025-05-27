<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Faculty;
use Illuminate\Http\Request;

class Course_Controller extends Controller
{
  public function index(Request $request)
{
    $query = Course::query();
    
    // Apply search filters
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('course_name', 'like', "%{$search}%")
              ->orWhere('course_code', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
    
    // Apply department filter
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }
    
    // Get paginated results with query string preservation
    $courses = $query->orderBy('course_name', 'asc')->paginate(6)->withQueryString();
    
    // Get departments for filter (from courses table, not faculty)
    $departments = Course::select('department')
                        ->distinct()
                        ->whereNotNull('department')
                        ->orderBy('department')
                        ->pluck('department')
                        ->toArray();
    
    // Fallback if no departments found
    if (empty($departments)) {
        $departments = ['No departments found.'];
    }

    return view('Course.course_list', [
        'courses' => $courses,
        'Departments' => $departments // Changed from $Departments to $departments for consistency
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

   public function schedule($course_code)
{
    // Retrieve the course with its sections and associated faculty
    $course = Course::where('course_code', $course_code)
                    ->with(['sections.faculty']) // eager load related sections and their faculty
                    ->first();

    if (!$course) {
        return redirect()->route('course.index')->with('error', 'Course not found.');
    }

    // Get the sections from the course, ordered by section number
    $sections = $course->sections->sortBy('section_number');

    return view('Course.course_schedule', compact('course', 'sections'));
}


}


