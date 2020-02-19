<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ExpenseCategory;
use Auth;
use Validator;
class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $categories =  ExpenseCategory::where('status' ,1)->get();
         return response()->json([
             'categories' => $categories,
             'status' => true,
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

        $validator  = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => false,
            ]);
         }

        $category = new ExpenseCategory();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return  response()->json([
            'message' => 'Category Successfully Added!',
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
    
        $category  = ExpenseCategory::find($id);
        return response()->json([
            'status' => true,
            'name' => $category->name,
            'description' => $category->description,
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
            'name' => 'required',
            'description'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => 'false',
            ]);
        }
        $category = ExpenseCategory::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        if($category->save()){
            return  response()->json([
                'message' => 'Expense Category Successfully Modified!',
                'name' => $category->name,
                'description'=>$category->description,
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
        $category = ExpenseCategory::where('id',$id)
                    ->where('status',1)
                    ->first();
        $category->status = 0;
        $category->save();
        return  response()->json([
            'message' => 'Expense Category Successfully Deleted!',
            'status' => true
          ]);
    }


    /// for chart 
     public function chart(){
           $categories = ExpenseCategory::where('status',1)->get()
                    ->map(function($data){
                        $data->total = $data->expenses()->where('user_id',Auth::user()->id)->pluck('amount')->sum();
                        return $data;
                    });
            return response()->json([
                'categories' => $categories,
                'status' => true,
            ]);
     }
}
