@csrf

<div class="field w-auto">
    <label for="title" class="label text-sm mb-2 block">Title</label>

    <div class="control my-2 w-full">
        <input
            type="text"
            class="input bg-transparent border border-gray-light rounded p-2 text-xs w-full"
            name="title"
            placeholder="My next awesome project"
            required
            value="{{$project->title}}">
    </div>
</div>

<div class="field mb-6">
    <label for="description" class="label">Description</label>

    <div class="control my-2">
            <textarea
                class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                style="min-height: 200px"
                name="description"
                required >{{$project->description}}</textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link">{{$buttonText}}</button>
        <a href="{{$project->path()}}">Cancel</a>
    </div>
</div>

@if($errors->any())
    <div class="field mt-6">
            @foreach($errors->all() as $error)
                <li class="text-sm text-red">{{$error}}</li>
            @endforeach
    </div>
@endif
