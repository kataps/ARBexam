<?php

use Illuminate\Database\Seeder;
use App\ExpenseCategory;
class ExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ExpenseCategory::truncate();
        $exp1 = ExpenseCategory::create([
            'name' => 'Travel',
            'description' =>'daily commute',
        ]);
        $exp2 = ExpenseCategory::create([
            'name' => 'Entertainment',
            'description' => 'movies etc'
        ]);

    }
}
