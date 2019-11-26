<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;
use Illuminate\Support\Arr;

class Task extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static $recordableEvents = ['created', 'deleted'];


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

}
