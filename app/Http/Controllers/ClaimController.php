<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Claim;
use App\Evidence;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailer;
use App\Mail\CMMailer;
use Session;
use Response;

class ClaimController extends Controller
{
  

    public function allCourses(){
        $course=Course::all();
        return view('new-claims')->with('courses',$course);
    }

    public function uploadClaim(Request $request,Mailer $mailer,$action){
            $claim=null;
            $lastId='';
            $student_id=Auth::user()->student_id;
            
        
        
        if($action=='new'){
            $faculty_email=DB::table('managements')
                ->join('faculties','managements.management_id','faculties.management_id')
                ->join('courses','courses.faculty_id','faculties.faculty_id')
                ->join('batches','courses.course_id','batches.course_id')
                ->join('students','batches.batch_id','students.batch_id')
                ->where('students.student_id',$student_id)
                ->select('managements.email')->first();
              
              
            $claim=new Claim();
            $claim->assessment_id=$request->assesment;
            $claim->claim_details=$request->claim_details;
            $claim->claim_type=$request->claim_type;
            $claim->student_id=$student_id;
            $claim->submission_date=date('Y-m-d');
            $claim->save();
//            $mailer->to('mrtanveer.29@gmail.com')->send(new CMMailer('You Have a Claim from A student Please check the application for details','Tanveer Hasan'));
            $lastId=DB::table('claims')->max('claim_id');
           
            
        }elseif($action=='update'){
            $claim=Claim::find($request->claim_id);
            $claim->evidences()->delete();

            $claim->assessment_id=$request->assesment;
            $claim->claim_details=$request->claim_details;
            $claim->claim_type=$request->claim_type;
            $claim->student_id=Auth::user()->student_id;
            $claim->submission_date=date('Y-m-d');
            $lastId=$request->claim_id;
            $claim->save();


            $perviousUpload=array();
            $previous_evidence_details=array();
            
            if($request->has('wasuploaded')){
                $perviousUpload=Input::get('wasuploaded');
                $previous_evidence_details=Input::get('previous_evidence_details');
                $counter=0;
                foreach($perviousUpload as $uploadFile){
                     $evidence=new Evidence();
                     
                     $evidence->details=$previous_evidence_details[$counter];
                     $evidence->evidence_file=$uploadFile;
                     $evidence->upload_date=date('Y-m-d');
                     $claim->evidences()->save($evidence);
                     $counter++;
                     


                }

              
            }
              
        }
        
        
        $file_details=$request->evidence_details;
        $files=Input::file('fileToUpload');
        $lastEvidence=DB::table('evidences')->max('evidence_id');
        $lastEvidence++;
        
        $fileName=array();
        $counter=0;

        if($files==null || $files==''){
             Session::flash('message',"Your Claim is submitted without ".$action." evidences");
            return redirect('allClaimsByStudent/'.$student_id);
        }
        foreach($files as $file){
            $evidence=new Evidence();
            $evidence->upload_date=date('Y-m-d');
            $evidence->details=$file_details[$counter];
            $fileName[$counter]=$lastId.$lastEvidence.".".$file->getClientOriginalExtension();
            $evidence->evidence_file=$fileName[$counter]; 
            $filePath='uploaded_file';
            $file->move($filePath,$fileName[$counter]);
            $claim->evidences()->save($evidence);

            $counter++;
            $lastEvidence++;
        }

        
        
        
        
       
        if($action=='update'){
            Session::flash('message',"Your Claim is Updated successfully");
        }else{
            Session::flash('message',"Your Claim is submitted successfully");
        }
        

        return redirect('allClaimsByStudent/'.$student_id);
    }
    
    public function viewClaims(){
        return  view('admin.claim');
    }
     public function getClaims($action){
        $user=Auth::guard('admin')->user();

        $faculty_id=0;
        if($user->type_id==1){
             $faculty_id=$user->faculties->faculty_id;
        }
       
     

        $claims = DB::table('claims')
         ->leftJoin('evidences', 'evidences.claim_id', '=', 'claims.claim_id')
        ->join('students', 'students.student_id', '=', 'claims.student_id')
        ->join('batches','batches.batch_id','students.batch_id')
        ->join('courses','courses.course_id','batches.course_id')
        ->join('faculties','faculties.faculty_id','courses.faculty_id')
        ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
        ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
        ->where('evidences.claim_id','!=',Null)
        ->select('courses.faculty_id','claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type')->get();

        

        if($user->type_id==1){
            $claims= DB::table('claims')
             ->leftJoin('evidences', 'evidences.claim_id', '=', 'claims.claim_id')
            ->join('students', 'students.student_id', '=', 'claims.student_id')
            ->join('batches','batches.batch_id','students.batch_id')
            ->join('courses','courses.course_id','batches.course_id')
            ->join('faculties','faculties.faculty_id','courses.faculty_id')
            ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
            ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
            ->where('faculties.faculty_id', $faculty_id)
            ->where('evidences.claim_id','!=',Null)
            ->select('courses.faculty_id','claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type')->get(); 

        }


        
        if($action=='pending'){
            return $claims->where('status','Pending');
        }else if($action=='latest'){
            $ldate = date('Y-m-d');
            return $claims->where('submission_date',$ldate);
        }else if($action=='approved'){
            return $claims->where('status','Approved');
        }else if($action=='all'){
            return $claims;
        }
        else if($action=='no-evidence'){
            $claims = DB::table('claims')
            ->join('students', 'students.student_id', '=', 'claims.student_id')
            ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
            ->leftJoin('evidences', 'evidences.claim_id', '=', 'claims.claim_id')
            ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
            ->where('evidences.claim_id',Null)
            ->select('claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type')->get();

            if($user->type_id==1){
                $claims = DB::table('claims')
                ->leftJoin('evidences', 'evidences.claim_id', '=', 'claims.claim_id')
                ->join('students', 'students.student_id', '=', 'claims.student_id')
                ->join('batches','batches.batch_id','students.batch_id')
                ->join('courses','courses.course_id','batches.course_id')
                ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
                ->join('faculties','faculties.faculty_id','courses.faculty_id')
                
                ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
                ->where('evidences.claim_id',Null)
                ->where('faculties.faculty_id', $faculty_id)
                ->select('claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type')->get();
                return $claims;
            }
             return $claims;
           
        }
        else if($action=='overdued'){
            $ldate = date('Y-m-d');
             $claims = DB::table('claims')
                ->join('students', 'students.student_id', '=', 'claims.student_id')  
                ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
                ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
                ->join('course_module', 'modules.module_id', '=', 'course_module.module_id')
                ->join('courses','courses.course_id','course_module.course_id')
                ->join('faculties','faculties.faculty_id','courses.faculty_id')
                ->where('status','Pending')
                ->select('claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type','courses.faculty_id')->get();

                if($user->type_id=1){
                  $claims = DB::table('claims')
                ->join('students', 'students.student_id', '=', 'claims.student_id')  
                ->join('assessments', 'assessments.assessment_id', '=', 'claims.assessment_id')
                ->join('modules', 'modules.module_id', '=', 'assessments.module_id')
                ->join('course_module', 'modules.module_id', '=', 'course_module.module_id')
                ->join('courses','courses.course_id','course_module.course_id')
                ->join('faculties','faculties.faculty_id','courses.faculty_id')
                ->where('status','Pending')
                ->where('courses.faculty_id', $faculty_id)
                ->select('claims.claim_id','claims.claim_details','module_name','status','submission_date','student_name','assessment_type','courses.faculty_id')->get();

                }

                $filterdClaim=array();
                $counter=0;

                for ($i=0; $i <sizeof($claims)-1 ; $i++) { 
                    $date=$claims[$i]->submission_date;
                    $date1=strtotime($date);
                    $date2=strtotime($ldate);
                    $diff=($date2-$date1)/(60*60*24); 

                     
                    if ( $diff>14) {
                        $filterdClaim[$counter]=$claims[$i];
                         $counter++;
                    }
                }
                

                return $filterdClaim ;
        }

        return  $claims;
    }

    public function claimAction($id,$action){
        // $claim= Claim::with('evidences','assessments','assessments.modules')->get()->find($id);
       
        if ($action=="details"){
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

        if($action=='reject'){
            $claim=Claim::find($id);
            $claim->status="Rejected";
            $claim->save();
        }

        if($action=='upheld'){
            $claim=Claim::find($id);
            $claim->status="Approved";
            $claim->save();
        }

        return redirect('admin/viewClaims');
        
    }
  
    public function getAllOverduedClaim(){}
}
