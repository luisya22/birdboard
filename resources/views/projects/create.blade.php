@extends('layouts.app')

@section('content')

    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <form method="POST" action="/projects">
            <h1 class="heading is-1">Let's start something new</h1>
            @include('projects.form', [
            'project' => new App\Project,
            'buttonText' => 'Create Project'
            ])
        </form>
    </div>

@endsection
