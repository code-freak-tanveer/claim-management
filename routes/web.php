<?php
use App\Student;
use App\Claim;
use App\Course;
use App\Assessment;
use App\Batch;
use App\Module;
use App\Faculty;
use App\Management;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();

// editional route

Route::get('viewfile/{filename}',function($filename){

$path = 'uploaded_file/'.$filename;

return Response::make(file_get_contents($path), 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="'.$filename.'"'
    ]);
});

// get route++++++++++++++++++++++++++++++++++++++++
Route::get('get/{faculty_id}/courses',function($id){
    $courses=Faculty::find($id)->courses;
    return $courses;
});

Route::get('get/faculties',function(){
    $faculties=Faculty::all();
    return $faculties;
});
Route::get('get/{faculty_id}/modules',function($id){
    $modules=DB::table('modules')->select('modules.module_id','module_name')
        ->join('course_module','course_module.module_id','modules.module_id')
        ->where('course_module.course_id',$id)->get();
    return $modules;
});
Route::get('get/modules',function(){
    $modules=Module::with('assessments','courses','courses.faculties')->orderBy('modules.module_id','DESC')->get();
    return $modules;
});


// Add route+++++++++++++++++++++++++++++++++++++++

Route::post('admin/view/add/module',function(Request $request){
    $course_id=$request->input('courses');
    $module=new Module();
    $module->module_name=$request->input('module_name');
    $module->save();



    $course=Course::find($course_id);
    $course->modules()->attach($module->module_id);
    $assessments=$request->input('assessment');

    foreach($assessments as $tmp){

        $assessment=new Assessment();
        $assessment->assessment_type=$tmp;
        $assessment->assessment_details=$tmp;
        $module->assessments()->save($assessment);
    }
    
    Session::flash('message',$module->module_name." Module Saved");
return redirect()->back();
});
Route::post('admin/view/add/batch',function(Request $request){

    $batch_start = date("Y-m-d", strtotime($request->input('batch_start')));
    $batch_end = date("Y-m-d", strtotime($request->input('batch_end')));

    $course=Course::find($request->input('courses'));
    $batch=new Batch();
    $batch->batch_title=$request->input('batch_title');

    $batch->session_start=$batch_start;
    $batch->session_end=$batch_end;

    $course->batches()->save($batch);

    $module_id=$request->input('modules');
    $module_start=$request->input('module_start');
    $module_end=$request->input('module_end');
    for($i=0; $i<=sizeof($module_id)-1; $i++){
        $batch->modules()->attach($module_id[$i],['module_start' => date('Y-m-d',strtotime($module_start[$i])),'module_end' => date('Y-m-d',strtotime($module_end[$i]))]);
    }
    Session::flash('message',"Batch Created Successfully");
    return redirect()->back();
});


// end Tests++++++++++++++++++++++++++++++++++++++++
Route::get('/home', 'HomeController@index');


// Route::get('send_mail',function(Mailer $mailer){
// });
Route::get('admin/claimscount',function(){

    $totalClaim=Claim::all()->count();

   // return DB::table('claims')->selectRaw('count(*) as count')->groupBy('claim_type')->get();
    $claim= Claim::selectRaw('((COUNT(DISTINCT claim_id) / '.$totalClaim.') * 100) as y, faculties.faculty_name as label, faculties.faculty_name as legendText')
    ->join('assessments','assessments.assessment_id','claims.assessment_id')
    ->join('modules','modules.module_id','assessments.module_id')
    ->join('course_module','course_module.module_id','modules.module_id')
    ->join('courses','course_module.course_id','courses.course_id')
    ->join('faculties','faculties.faculty_id','courses.faculty_id')
    ->groupBy('faculties.faculty_id')->get();
    return $claim;
});

Route::get('admin/module_claims',function(){
    $claim= Claim::selectRaw('10 as x, COUNT(DISTINCT claim_id) as y, faculties.faculty_name as label, faculties.faculty_name as legendText')
    ->join('assessments','assessments.assessment_id','claims.assessment_id')
    ->join('modules','modules.module_id','assessments.module_id')
    ->join('course_module','course_module.module_id','modules.module_id')
    ->join('courses','course_module.course_id','courses.course_id')
    ->join('faculties','faculties.faculty_id','courses.faculty_id')
    ->groupBy('faculties.faculty_id')->get();
  
    $x=10;
    foreach($claim as $tmp){
        $tmp->x=$x;
        $x+=10;
    }
    return $claim;
});

Route::get('admin/claims/student',function(){

    $claim= Claim::selectRaw('10 as x, COUNT(DISTINCT students.student_id) as y, faculties.faculty_name as label, faculties.faculty_name as legendText')
    ->join('students','students.student_id','claims.student_id')
    ->join('batches','batches.batch_id','students.batch_id')
    ->join('courses','courses.course_id','batches.course_id')
    ->join('faculties','faculties.faculty_id','courses.faculty_id')
    ->groupBy('faculties.faculty_id')->get();
  
    $x=10;
    foreach($claim as $tmp){
        $tmp->x=$x;
        $x+=10;
    }
    return $claim;
});

Route::get('profile/{id}',function($id){

    $student=DB::table('students')
    ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
    ->join('courses', 'batches.course_id', '=', 'courses.course_id')
    ->join('faculties', 'faculties.faculty_id', '=', 'courses.faculty_id')
    ->where('students.student_id',$id)->first();
  
    return view('pages.profile')->with('student', $student);
});

Route::get('logout',function (){
    Auth::guard('web')->logout();
    return redirect('login');
});

Route::get('allClaimsByStudent/{id}',function ($id){
    $claims = DB::table('claims')
        ->join('students', 'students.student_id', '=', 'claims.student_id')
        ->join('batches', 'students.batch_id', '=', 'batches.batch_id')
        ->join('courses', 'batches.course_id', '=', 'courses.course_id')
        ->join('batch_course_module', 'batch_course_module.batch_id', '=', 'batches.batch_id')
        ->join('modules', 'batch_course_module.module_id', '=', 'modules.module_id')
        ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
        ->select('claims.claim_id','status','claims.claim_details','student_name','submission_date','module_end','claim_type','course_name','module_name','assessment_type')
        ->groupBy('claims.claim_id')
        ->orderBy('claims.claim_id', 'DESC')
        ->where('students.student_id',$id)->paginate(10);
        
   return  view('pages.claim')->withClaims($claims);
})->middleware('auth');

Route::get('claim/{id}/{action}', function($id, $action){
   
    

   if($action=='delete'){
        $claim=Claim::find($id);
        $claim->delete();
        Session::flash('message', "Delete Successful");
        return redirect()->back();
   }
   else if($action=='edit'){
        $claim= Claim::with('assessments','evidences','assessments.modules')->find($id);
        // return $claim;
        return view('pages.edit-claims')->with('claim',$claim);
   }else if($action=='details'){
        $claim=DB::table('claims')
        ->join('students', 'students.student_id', '=', 'claims.student_id')
        ->join('batches', 'batches.batch_id', '=', 'students.batch_id')
        ->join('courses', 'courses.course_id', '=', 'batches.course_id')
        ->join('faculties', 'faculties.faculty_id', '=', 'courses.faculty_id')
        ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
        ->join('modules', 'assessments.module_id', '=', 'modules.module_id')
  
        ->where('claims.claim_id',$id)->get();

        $evidence=Claim::find($id)->evidences;
      
    return view('pages.claim-details')->with('claims',$claim)->with('evidences',$evidence);
   }
});





Route::get('form/create/claim', function (){
    return view('pages.new-claims');
});

Route::post('claim/{new}','ClaimController@uploadClaim');

// module and assessments
Route::get('{id}/modules', function ($id){
    return Batch::find($id)->modules;
});


Route::get('{id}/assessments', function ($id){
    return Module::find($id)->assessments;
});

// end section
Route::post('login_action','Auth\LoginController@login');


//Route::get('addClaim', function (Request $req){
//    $claim=new Claim();
//    $claim->claim_details=Input::get('claim');
//    $claim->save();

//    return Redirect::back();
//});

Route::group(['prefix'=>'admin'],function(){
    Route::get('students','Controller@allStudent');
    Route::post('login','AuthenticationController@login')->name('admin.login');
    Route::post('claim/action', function(Request $request){
            $id=$request->get('claim_id');
            $claim=Claim::find($id);

            $claim->status=$request->get('action');
            $claim->comments=$request->get('comments');
            $claim->save();

            Session::flash('message', "Action Applied");
            return redirect()->back();
    });


    Route::post('update/reset_password/{type}',function($type,Request $request){
            $id=$request->input('id');
            $password=$request->input('password');

            if($type=='student'){
               $student= Student::find($id);

               $student->password=bcrypt($password);
               $student->save();

            }

            if($type=='staff'){
               $management= Management::find($id);

               $management->password=bcrypt($password);
               $management->save();

            }

            Session::flash('message',"Password Updated");
            return redirect()->back();
    });
    Route::get('claim/{action}','ClaimController@getClaims')->middleware('admin');;
    Route::get('claim/{id}/{details}','ClaimController@claimAction')->middleware('admin');;
    Route::get('viewClaims','ClaimController@viewClaims')->middleware('admin');;
    Route::get('dashboard',function(){return view('admin/dashboard');})->name('admin.dashboard')->middleware('admin');
    Route::get('logout',function (){Auth::guard('admin')->logout();return redirect('login');});

    Route::get('view/students', function(){return view('admin.students');})->middleware('admin');;
    Route::get('reset_password/{type}', function($type){

        if($type=='student'){
            return view('admin.student_password_reset');
        }
        else{
            return view('admin.staff_password_reset');
        }
        
    });
    // test Routes ++++++++++++++++View ++++++++++++++++++++
    Route::get('view/module', function(){return view('admin.module');});
    Route::get('view/batch', function(){return view('admin.batch');});


    
});
