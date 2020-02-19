<?php

namespace App\Http\Controllers\Website;

use Auth;
use App\Expenses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Validator;
use App\ExpenseCategory;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $expenses =  Expenses::where('status' ,1)->where('user_id','=',Auth::user()->id)
                    ->get()
                    ->map(function($data){
                        $data->categoryName = $data->expense_category()->first()->name;
                        return $data;
                    });
        return response()->json([
            'expenses' => $expenses,
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
        $validator = Validator::make($request->all(),[
            'category' => 'required',
            'amount' => 'required|integer|min:0',
            'edate' => 'required',
        ]);
         if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => false,
            ]);
         }
         $category =  ExpenseCategory::where('id','=',$request->category)->first();
         $category->expenses()->create([
            'amount' => $request->amount,
            'entry_date' => $request->edate,
            'user_id' => Auth::user()->id,
         ]);
         return  response()->json([
            'message' => 'Expense Successfully Added!',
            'status' => true
         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user_id = Auth::user()->id;
        $expense  = Expenses::where('id','=',$id)
                        ->where('user_id','=',$user_id)
                        ->first();
        return response()->json([
            'status' => true,
            'amount' => $expense->amount,
            'category_id' => $expense->expense_category()->first()->id,
            'edate' => $expense->entry_date,
        ]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'category' => 'required',
            'amount' => 'required|integer|min:0',
            'edate' => 'required',
        ]);

         if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->toArray(),
                'status' => false,
            ]);
         }
         $category = ExpenseCategory::where('id','=',$request->category)->first();
         $expense = Expenses::where('id','=',$id)->where('status','=',1)->first();
         $expense->expense_category()->associate($category);
         $expense->amount = $request->amount;
         $expense->entry_date = $request->edate;
         $expense->save();
         return  response()->json([
            'message' => 'Expense Successfully Modified!',
            'status' => true
         ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $category = Expenses::where('id','=',$id)
        ->where('status',1)
        ->where('user_id','=',Auth::user()->id)
        ->first();
        $category->status = 0;
        $category->save();
        return  response()->json([
        'message' => 'Expense Successfully Deleted!',
        'status' => true

        ]);

    }
}
