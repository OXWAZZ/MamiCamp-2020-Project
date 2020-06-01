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

                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input name="body" value="{{ $task->body }} " class="w-full border-0 {{ $task->completed ? 'line-through text-gray' : ''}}">
                                    <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                            
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input name="body" placeholder="Begin adding tasks..." class="border-0 w-full">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-gray font-normal">General Notes</h2>
                    <textarea class="card w-full border-0" style="min-height: 200px; max-width: 900px;">Lorem Ipsum</textarea>
                </div>            
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>

        </div>
    </main>
@endsection