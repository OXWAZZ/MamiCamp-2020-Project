<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index () {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show (Project $project) {
        if (auth()->id() != $project->owner_id) {
            abort(403);
        }
        
        return view('projects.show', compact('project'));
    }

    public function store () {

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
             ]);
        
        $project = auth()->user()->projects()->create($attributes);
        
        return redirect($project->path());
    }

    public function create ()
    {
        return view('projects.create');
    }
    
}
