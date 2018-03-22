<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'title',
        'source_id',
        'what',
        'why',
        'when',
        'who',
        'where',
        'how_1',
        'how_2',
        'image_path',
        'manager_id',
        'creator_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->manager_id);
    }
}
