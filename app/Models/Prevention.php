<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prevention extends Model
{
    protected $table = 'preventions';
    protected $fillable = [
        'name',
        'budget',
        'creator_id',
        'preventor_id',
        'pre_preventor_id',
        'where',
        'when',
        'how',
        'status_id',
        'ticket_id',
        'is_on_time',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function preventor()
    {
        return $this->belongsTo(User::class, 'preventor_id');
    }
    public function pre_preventor()
    {
        return $this->belongsTo(User::class, 'pre_preventor_id');
    }
    public function status()
    {
        return$this->belongsTo(Status::class, 'status_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function getCreatorUserAttribute()
    {
        return User::findOrFail($this->creator_id);
    }
    public function getPreventorUserAttribute()
    {
        return User::findOrFail($this->preventor_id);
    }
    public function getPrePreventorUserAttribute()
    {
        return User::findOrFail($this->pre_preventor_id);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }
}
