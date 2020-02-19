<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseCategory;
class Expenses extends Model
{
    //
    protected $fillable = [
        'amount','entry_date','user_id'
    ];
    public function expense_category(){
       return  $this->belongsTo(ExpenseCategory::class);      
    }   
}
