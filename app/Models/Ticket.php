<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'title',
        'deadline',
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
        'manager_confirmation_result',
        'manager_confirmation_comment',
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
    public function getCreatorUserAttribute()
    {
        return User::findOrFail($this->creator_id);
    }
    public function getManagerUserAttribute()
    {
        return User::findOrFail($this->manager_id);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }
}
