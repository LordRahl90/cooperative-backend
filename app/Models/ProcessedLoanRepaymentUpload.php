<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedLoanRepaymentUpload extends Model
{
    use HasFactory;

    protected $guarded = ['deleted_at'];
}
