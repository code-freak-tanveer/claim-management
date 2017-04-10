<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticationController extends Controller
{
   
    public function login(){
        $user=Input::except(array('_token'));
      
        if(Auth::guard('admin')->attempt($user)){
        	$role=Auth::guard('admin')->user()->type_id;
            
            if($role==1){
                return redirect('/admin/viewClaims');
            }
            
            return redirect()->route('admin.dashboard');
        }
        else{
             Session::flash('message', "Wrong email or password");
             return Redirect::back()->withInput($user);
            
        }
        
    }
}
