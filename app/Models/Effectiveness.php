<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effectiveness extends Model
{
    protected $table = 'effectivenesses';
    protected $fillable = ['name', 'color'];
}
