<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //
    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory', 'expense_category_id', 'id');
    }



}
