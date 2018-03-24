<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Troubleshoot extends Model
{
    protected $table = 'troubleshoots';

    protected $fillable = [
        'name',
        'troubleshooter_id',
        'pre_troubleshooter_id',
        'creator_id',
        'ticket_id',
        'deadline',
        'status_id',
        'is_on_time',
    ];

    public function troubleshooter()
    {
        return $this->belongsTo(User::class, 'troubleshooter_id');
    }
    public function pre_troubleshooter()
    {
        return $this->belongsTo(User::class, 'pre_troubleshooter_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function getCreatorUserAttribute()
    {
        return User::findOrFail($this->creator_id);
    }
    public function getTroubleshooterUserAttribute()
    {
        return User::findOrFail($this->troubleshooter_id);
    }
    public function getPreTroubleshooterUserAttribute()
    {
        return User::findOrFail($this->pre_troubleshooter_id);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }

}
