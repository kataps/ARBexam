<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $roles = Role::all()->where('status',1);
            return response()->json([
                 'roles'=>$roles,
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
        $validator =  Validator::make($request->all(),[
                'roleName' => 'required',
                'roleDesc'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => 'false',
            ]);
         }
         Role::create([
             'name' => $request->roleName,
             'description' =>  $request->roleDesc,
         ]);

         return  response()->json([
            'message' => 'Role Successfully Added!',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role  = Role::find($id);
        return response()->json([
            'status' => true,
            'roleName' => $role->name,
            'roleDesc' => $role->description,
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
        $validator =  Validator::make($request->all(),[
            'roleName' => 'required',
            'roleDesc'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => 'false',
            ]);
        }
        $role = Role::findOrFail($id);
        $role->name = $request->roleName;
        $role->description = $request->roleDesc;
        if($role->save()){
            return  response()->json([
                'message' => 'Role Successfully Modified!',
                'status' => true
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
        $role = Role::where('id',$id)
                    ->where('status',1)
                    ->first();
       
        $role->status = 0;
        $role->save();
        return  response()->json([
            'message' => 'Role Successfully Deleted!',
            'status' => true
          ]);
    }
}
