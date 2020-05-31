@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray text-sm font-normal">
                <a href="/projects" class="no-underline text-gray">My Projects</a> / {{ $project->title}}
            </h2>
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3" style="box-sizing: border-box;">

            <div class="lg:w-3/4 px-3 mb-8">
                <div class="mb-6">
                    <h2 class="text-lg text-gray font-normal">Tasks</h2>
                    <div class="card mb-6">Lorem Ipsum</div>
                    <div class="card mb-6">Lorem Ipsum</div>
                    <div class="card mb-6">Lorem Ipsum</div>
                    <div class="card">Lorem Ipsum</div>
                </div>

                <div>
                    <h2 class="text-lg text-gray font-normal">General Notes</h2>
                    <textarea class="card w-full " style="min-height: 200px; max-width: 900px;">Lorem Ipsum</textarea>
                </div>            
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>

        </div>
    

    </main>

    
@endsection