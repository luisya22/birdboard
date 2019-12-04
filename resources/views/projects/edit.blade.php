@extends('layouts.app')

@section('content')

    <div class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow">
        <form method="POST" action="{{$project->path()}}">
            @method('PATCH')

            <h1 class="tet-2xl font-normal mb-10 text-center">Edit Your Project</h1>

            @include('projects.form', [
                'buttonText' => 'Update Project'
            ])
        </form>
    </div>

@endsection
