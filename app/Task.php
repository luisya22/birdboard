<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean'
    ];

//    protected static function boot(){
//        parent::boot();
//
//        static::created(function($task){
//
//            $task->project->recordActivity('Created task');
//        });
//
//        static::deleted(function($task){
//
//            $task->project->recordActivity('Task deleted');
//        });
//
//    }


    protected $touches = ['project'];

    public function project(){

        return $this->belongsTo(Project::class);
    }

    public function path(){

        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete(){

        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');

    }

    public function incomplete(){

        $this->update(['completed' => false]);

        $this->recordActivity('incompleted_task');


    }

    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }
}
