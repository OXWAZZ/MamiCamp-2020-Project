<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index () {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show (Project $project)
    {
        $this->authorize('update', $project);
        
        return view('projects.show', compact('project'));
    }

    public function store () {

        $attributes = $this->validateRequest();

        $project = auth()->user()->projects()->create($attributes);
        
        return redirect($project->path());
    }

    public function edit (Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function create ()
    {
        return view('projects.create');
    }
    
    public function update (UpdateProjectRequest $form)
    {
        // $request->save();
        // $project->update($request->validated());
        
        return redirect($form->save()->path());
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable',
             ]);
    }
}
