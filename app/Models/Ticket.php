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
        'manager_confirmation_result_id',
        'manager_confirmation_comment',
        'responsibility_id',
        'root_cause_type_id',
        'evaluation_id',
        'root_cause',
        'root_cause_approver_id',
        'evaluation_result_id',
        'effectiveness_id',
        'effectiveness_assessor_id',
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
    public function root_cause_approver()
    {
        return $this->belongsTo(User::class, 'root_cause_approver_id');
    }
    public function effectiveness()
    {
        return $this->belongsTo(Effectiveness::class, 'effectiveness_id');
    }
    public function effectiveness_assessor()
    {
        return $this->belongsTo(User::class, 'effectiveness_assessor_id');
    }
    public function manager_confirmation_result()
    {
        return $this->belongsTo(ApproveResult::class, 'manager_confirmation_result_id');
    }
    public function getCreatorUserAttribute()
    {
        return User::findOrFail($this->creator_id);
    }
    public function getManagerUserAttribute()
    {
        return User::findOrFail($this->manager_id);
    }
    public function getRootCauseApproverUserAttribute()
    {
        return User::findOrFail($this->root_cause_approver_id);
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
