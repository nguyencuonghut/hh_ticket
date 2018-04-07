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
        'director_id',
        'creator_id',
        'department_id',
        'director_confirmation_result_id',
        'director_confirmation_comment',
        'assigned_troubleshooter_id',
        'approve_troubleshoot_result_id',
        'approve_troubleshoot_comment',
        'responsibility_id',
        'assigned_preventer_id',
        'root_cause_type_id',
        'evaluation_id',
        'root_cause',
        'evaluation_result_id',
        'approve_prevention_result_id',
        'approve_prevention_comment',
        'effectiveness_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }
    public function evaluation_result()
    {
        return $this->belongsTo(ApproveResult::class, 'evaluation_result_id');
    }
    public function root_cause_type()
    {
        return $this->belongsTo(RootCauseType::class, 'root_cause_type_id');
    }
    public function effectiveness()
    {
        return $this->belongsTo(Effectiveness::class, 'effectiveness_id');
    }
    public function director_confirmation_result()
    {
        return $this->belongsTo(ApproveResult::class, 'director_confirmation_result_id');
    }
    public function assigned_troubleshooter()
    {
        return $this->belongsTo(User::class, 'assigned_troubleshooter_id');
    }
    public function approve_troubleshoot_result()
    {
        return $this->belongsTo(ApproveResult::class, 'approve_troubleshoot_result_id');
    }
    public function assigned_preventer()
    {
        return $this->belongsTo(User::class, 'assigned_preventer_id');
    }
    public function approve_prevention_result()
    {
        return $this->belongsTo(ApproveResult::class, 'approve_prevention_result_id');
    }
    public function getCreatorUserAttribute()
    {
        return User::findOrFail($this->creator_id);
    }
    public function getDirectorUserAttribute()
    {
        return User::findOrFail($this->director_id);
    }
    public function getAssignedTroubleshooterUserAttribute()
    {
        return User::findOrFail($this->assigned_troubleshooter_id);
    }
    public function getAssignedPreventerUserAttribute()
    {
        return User::findOrFail($this->assigned_preventer_id);
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }
    public function responsibility()
    {
        return $this->belongsTo(Responsibility::class, 'responsibility_id');
    }
    public function troubleshoots()
    {
        return $this->hasMany(Troubleshoot::class, 'ticket_id', 'id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'source');
    }
    public function addComment($reply)
    {
        $reply = $this->comments()->create($reply);
        return $reply;
    }
}
