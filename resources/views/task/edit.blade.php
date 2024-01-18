@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Task</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('task.update', $task->id)}}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="title" class="form-label">Task Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" required>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Task Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == $task->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="priority_id" class="form-label">Task Priority</label>
                                <select name="priority_id" id="priority_id" class="form-control">
                                    @foreach($priorities as $priority)
                                        <option value="{{$priority->id}}" {{$priority->id == $task->priority_id ? 'selected' : ''}}>{{$priority->name}}</option>
                                    @endforeach
                                </select>
                                @error('priority_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
