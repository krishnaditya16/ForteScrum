<x-app-layout>
    <x-slot name="title">{{ __('Create Task') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Task') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('task.index') }}">Task</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new task data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{ route('task.index') }}"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="task/kanban"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{ route('board.create') }}"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link active" href="{{ route('task.create') }}"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                    <form action="{{ route('task.store') }}" method="post">
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Boards</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="board_id">
                                    <option selected disabled> Select Board </option>
                                    @foreach ($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->title }}</option>
                                    @endforeach
                                </select>
                                @error('board_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="project_id">
                                    <option selected disabled> Select Project </option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Assigned User</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="assigned[]" multiple="">
                                    <option disabled> Select Users from Team </option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Priority</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="priority">
                                    <option selected disabled> Select Priority </option>
                                    <option value="0">Normal</option>
                                    <option value="1">High</option>
                                    <option value="2">Urgent</option>
                                    <option value="3">Low</option>
                                </select>
                                @error('platform') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start - End Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange" name="project_date" value="{{ old('project_date') }}">
                                </div>
                                @error('project_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Create Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
