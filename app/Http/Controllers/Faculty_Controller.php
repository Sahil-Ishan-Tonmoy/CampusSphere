<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;


class Faculty_Controller extends Controller
{
    public function index()
{
    $faculties = Faculty::orderBy('name', 'asc')->paginate(9);

    $Departments = Faculty::select('department')->distinct()->pluck('department')->toArray();

    
    if (empty($Departments)) {
        $Departments = ['No departments found.'];
    }

    if ($faculties->isEmpty()) {
        return view('Faculty.faculty_list', [
            'message' => 'No faculty members found.',
            'Departments' => $Departments
        ]);
    }

    return view('Faculty.faculty_list', [
        'faculties' => $faculties,
        'Departments' => $Departments
    ]);
}

    public function show($id)
    {
        $faculty = Faculty::where('faculty_id', $id)->first();

        if (!$faculty) {
            return redirect()->route('/faculty_list')->with('error', 'Faculty member not found.');
        }

        return view('Faculty.faculty_details', ['faculty' => $faculty]);
    }

    public function create()
    {
        // Logic to show a form for creating a new faculty member
    }
    public function store(Request $request)
    {
        // Logic to store a new faculty member in the database
    }
    public function edit($id)
    {
        // Logic to show a form for editing an existing faculty member
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing faculty member in the database
    }
    public function destroy($id)
    {
        // Logic to delete a faculty member from the database
    }
    public function search(Request $request)
    {
        // Logic to search for faculty members based on the request parameters
    }
    public function filter(Request $request)
    {
        // Logic to filter faculty members based on the request parameters
    }
    public function sort(Request $request)
    {
        // Logic to sort faculty members based on the request parameters
    }
}
