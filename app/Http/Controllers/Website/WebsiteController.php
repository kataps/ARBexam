<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Validator;
use Auth;

use App\User;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('app');
    }
    public function login(Request $request){
        
        $message = (object)[];
        $status = false;

        $validator = Validator::make($request->all(),[
            'email'  => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
             return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => 'false',
          ]);
        }
        if(Auth::attempt(['email' => $request->email , 'password' => $request->password])){
             $status = true;
             $message->userData =true;
      
        }else{
             $status = false;
            $message->loginAttempt = ["Wrong Username of Password"];
        }
        return response()->json([
                'message' => $message,
                'status' => $status,
        ]);
    }
    public function checkLogin(){
        if(Auth::check()){
            $user = User::where('id','=',Auth::user()->id)->get()
            ->map(function($data){
                    $data->access_lvl = $data->roles()->first()->name;
                    return $data;       
            });
            return response()->json([
                'userData' =>  $user,
                'status' => true
            ]);
        }else{
            return response()->json([
                'userData' => false,
                'status' => false,
            ]);
        }
 }
 public function signout(){
    if(Auth::check()){
        Auth::logout();
        return response()->json([
            'status'=> true,
        ]);
    }
 }
  public function saveProfile (){
 
       $use =  User::find(Auth::user()->id);
  }
}