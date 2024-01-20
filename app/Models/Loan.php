<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'loans';
    protected $fillable = ['user_id','amount','loan_term', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
