<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Expenses;
class ExpenseCategory extends Model
{
    //
    protected $fillable =[
         'name','description'
    ];
    public function expenses(){
        return  $this->hasMany(Expenses::class);
    }
}