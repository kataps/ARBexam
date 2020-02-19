<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\User;
use App\Role;
use Auth;
use Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //get users who are active
            $users  = User::where('id','!=',Auth::user()->id)->where('status',1)->get()->map(function($data){
                        $data->role = $data->roles()->first()->name;
                        return $data;
                      });
            return response()->json([
                'users'=>$users,
                'status' => true
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $message  = (object) [];
        $status = false;
        $validator  = Validator::make($request->all(),[
                    'email' => 'unique:users,email|required|email',
                    'password' => 'required|confirmed',
                    'name' => 'required',
                    'role' => 'required',
                    'username' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
               'message' => $validator->errors()->toArray(),
               'status' => 'false',
             ]);
         }
         $user = User::create([
             'username' => $request->username,
             'password' => Hash::make($request->password),
             'name' => $request->name,
             'email' => $request->email,
         ]);

         $role = Role::where('id','=',$request->role)->first();
         $user->roles()->attach($role);

         return  response()->json([
         'message' => 'User Successfully Saved!',
         'status' => true
         ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id','=',$id)->where('status',1)->first();
    
        return response()->json([
            'user' => $user,
            'role' => $user->roles()->first()->id,
            'status' => true,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message  = (object) [];
        $validator  = Validator::make($request->all(),[
                    'email' => 'sometimes|unique:users,email,'.$id.'|email',
                    'password' => 'sometimes|confirmed|min:8|max:8',
                    'name' => 'sometimes|min:5',
                    'username' => 'sometimes|min:5',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => 'false',
              ]);
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        //updating Role
         $role = Role::where('id','=',$request->role)->first();
       

        if($user->save()){
            if($user->roles()->sync([$role->id])){
                return  response()->json([
                    'message' => 'User Successfully Modified!',
                    'status' => true
                ]);
            }else{
                return  response()->json([
                    'message' => 'User Failed Syncing Role!',
                    'status' => false
                ]);
            }
            
        }else{
            return  response()->json([
                'message' => 'User failed Update Changes!',
                'status' => false
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $Deluser = User::where('id',$id)->first();
        $Deluser->status = 0;
        $Deluser->save();
        //get All users who are active
        return $this->index();
    }
    public function saveProfile (){
       $user =  User::find(Auth::user()->id);
       $user->password = Hash::make(request()->newpassword);
       $user->save();
       return response()->json([
           'status' => true,
       ]);
   }
}