@extends('layouts.app')

@section('content')

    <header class="flex items-end mb-3 py-4" >

        <div class="flex justify-between items-center w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline"> My Projects</a> / {{$project->title}}
            </p>
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
    {{--                tasks--}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">

                            <form method="POST" action="{{$task->path()}}">
                                @csrf
                                @method('PATCH')

                                <div class="flex">
                                    <input class="w-full {{$task->completed ? 'text-grey' : ''}}" name="body" value="{{$task->body}}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form method="POST" action="{{$project->path() . '/tasks'}}">
                            @csrf
                            <input class="w-full" type="text" placeholder="Add a new task..." name="body">
                        </form>
                    </div>

                </div>

                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    {{--                General notes--}}
                    <form method="POST" action="{{$project->path()}}">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            style="min-height: 200px"
                            placeholder="Anything specia that you want to make a note of?"
                        >{{$project->notes}}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>
                </div>

            </div>

            <div class="lg:w-1/4 px-3">
                    @include('projects.card')
            </div>
        </div>


    </main>

@endsection
