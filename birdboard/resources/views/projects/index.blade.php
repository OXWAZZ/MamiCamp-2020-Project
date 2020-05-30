<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <h1>Birdboard</h1>
    <ul>
        @forelse ($projects as $project)
            <li>
             <a href="{{ $project->path() }}">{{$project->title}}</a>
            </li>
        @empty
        <li>no project yet.</li>
        @endforelse
    </ul>
        
</body>
</html>