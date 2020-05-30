<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index () {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show (Project $project) {

        // if (auth()->id() !== $project->owner_id) {
        //     abort(403);
        // }

        return view('projects.show', compact('project'));
    }

    public function store () {

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
             ]);
        
        // $attributes['owner_id'] = auth()->id();

        auth()->user()->projects()->create($attributes);
        
        // Project::create($attributes);
        
        return redirect('/projects');
    }
    
}