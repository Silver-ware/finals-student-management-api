<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewStudentInfoRequest;
use App\Http\Requests\UpdateStudentInfoRequest;
use Illuminate\Http\Request;
use App\Models\StudentInfo;

class StudentInfoController extends Controller
{
    //GET Index
    public function index(Request $request){
        $student_query = StudentInfo::query();

        //SORT
        if ($request->has('sort')) {
            $sortDirection = strtolower($request->get('direction', 'asc')) === 'desc' ? 'desc' : 'asc';
            $student_query->orderBy($request->sort, $sortDirection);
        }

        //SEARCH
        if ($request->has('search')) {
            $search = $request->search;
            $student_query->where(function ($subQuery) use ($search) {
                $subQuery->where('firstname', 'like', "%{$search}%")
                         ->orWhere('lastname', 'like', "%{$search}%");
            });
        }

        //FIELDS //YEAR //COURSE //SECTION
        $field_queries = $request->get('fields');
        $year = $request->get('year');
        $course = strtoupper($request->get('course'));
        $section = strtoupper($request->get('section'));
        if ($year || $course || $section || $field_queries) {
            if($year){
                $student_query->where('year', $year);
            }
            if($course){
                $student_query->where('course', $course);
            }
            if($section){
                $student_query->where('section', $section);
            }
            if($field_queries){
                $field_queriesArray = explode(',', $field_queries);
                $student_query->select($field_queriesArray);
            }
        }

        //LIMIT & OFFSET
        $limit = $request->get('limit') ? $request->limit: 5;
        $offset = $request->get('offset', 1) ? $request->limit: 1;
        $students = $student_query-> paginate($limit, ['*'], 'page', $offset);

        return response()->json([
            'metadata' => [
                'count' => $students->total(),
                'search' => $request->get('search', null),
                'limit' => $students->perPage(),
                'offset' => $students->currentPage(),
                'fields' => $request->get('fields', ['id', 'firstname', 'lastname', 'birthdate', 'sex', 'address', 'year', 'course', 'section']),
            ],
            'students' => $students->items(),
        ]);
    }

    //POST
    public function register(NewStudentInfoRequest $request)
    {
        $student_validated = $request->validated();
        $new_student = StudentInfo::create($student_validated);
        return response()->json($new_student);
    }

    //GET (SPECIFIC)
    public function find(Request $request, $id){
        $find_student = StudentInfo::findOrFail($id);
        return response()->json($find_student);
    }

    //PATCH
    public function update(UpdateStudentInfoRequest $request, $id){
        $update_student = StudentInfo::findOrFail($id);
        $update_student->update($request->validated());
        return response()->json($update_student);

    }
}
