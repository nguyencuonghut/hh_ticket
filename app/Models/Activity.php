<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_log';
    protected $fillable = [
        'user_id',
        'text',
        'source_type',
        'source_id',
        'action',
    ];
    protected $guarded = ['id'];

    /**
     * Get the user that the activity belongs to.
     *
     * @return object
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function source() {
        return $this->morphTo();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    public function troubleshoot()
    {
        return $this->belongsTo(Troubleshoot::class, 'troubleshoot_id', 'id');
    }

    public function prevention()
    {
        return $this->belongsTo(Prevention::class, 'prevention_id', 'id');
    }
}
