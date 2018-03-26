<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproveResult extends Model
{
    protected $table = 'approve_results';
    protected $fillable = ['name', 'color'];
}
