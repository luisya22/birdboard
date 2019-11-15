<!DOCTYPE html>

<html>
    <head>
        <title></title>
    </head>
    <body>
        <h1>Birdboard</h1>

    <ul>
        @forelse($projects as $project)
                <a href="{{$project->path()}}"><li>{{$project->title}}</li></a>
        @empty
            <li>No projects yet.</li>
        @endforelse

    </ul>
    </body>
</html>
