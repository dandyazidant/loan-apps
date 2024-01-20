<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanBill extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'loan_bills';
    protected $fillable = [
        'loan_id', 'due_at', 'amount', 'penalty'
    ];
}
