<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    //
    public function expense()
    {
        return $this->hasOne('App\Expense');
    }
}
