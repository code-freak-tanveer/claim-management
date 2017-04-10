<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function allStudent()
        {
            $students=DB::table('students')->select('student_id','student_name','contact','course_name','batch_title','faculty_name')
            ->join('batches', 'batches.batch_id', '=', 'students.batch_id')
            ->join('courses', 'courses.course_id', '=', 'batches.course_id')
            ->join('faculties', 'faculties.faculty_id', '=', 'courses.faculty_id')->get();

            return $students;
        }
}
