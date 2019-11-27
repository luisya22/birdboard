<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    public function index(){

        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project){

        $this->authorize('update',$project);

        return view('projects.show', compact('project'));
    }

    public function create(){

        return view('projects.create');
    }

    public function store(){
        //validate
        $attributes = $this->validateRequest();

        //persist
        $project = auth()->user()->projects()->create($attributes);

        //redirect
        return redirect($project->path());
    }

    public  function edit(Project $project){

        return view('projects.edit',compact('project'));
    }

    public function update(Project $project){

        $this->authorize('update',$project);

        $attributes = $this->validateRequest();

        $project->update($attributes);

        return redirect($project->path());
    }

    public function destroy(Project $project){

        $this->authorize('update',$project);

        $project->delete();

        return redirect('/projects');
    }

    /**
     * @return mixed
     */
    protected function validateRequest()
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        return $attributes;
    }
}
