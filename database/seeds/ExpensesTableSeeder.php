<?php

use Illuminate\Database\Seeder;
use App\Expenses;
use App\ExpenseCategory;
use App\User;
class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $travel = ExpenseCategory::where('name','=','Travel')->first();
        
        $intertainment = ExpenseCategory::where('name','=','Entertainment')->first();

        Expenses::truncate();
        $user1 = User::where('email','=','admin@exam.com')->first();
        $user2 = User::where('email','=','juan@exam.com')->first();
        $travel->expenses()->create([
            'amount' => '1000',
            'entry_date' => '2020-02-18',
            'user_id' => $user1->id,
        ]);
        $intertainment->expenses()->create([
            'amount' => '2000',
            'entry_date' => '2020-02-19',
            'user_id' => $user2->id,
        ]);
    }
}
