<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function categories(){
        return $this->belongsToMany(ExpenseCategory::class, 'expense_has_categories', 'expense_id', 'category_id')
                ->withTimestamps();
    }
}
