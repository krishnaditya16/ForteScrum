<x-app-layout>
    <x-slot name="title">{{ $data->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $data->title }} - {{ __('Tasks Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $data->id }}">#{{ $data->id }}</a></div>
            <div class="breadcrumb-item">Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Kanban</h2>
    <p class="section-lead">
        You can manage & view tasks data using the kanban board below.
    </p>

    <div class="row mb-4 mt-2">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/table-view"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/create-board"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/create-task"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $data->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('pages.project.task.list')

</x-app-layout>

<!-- Modal -->
@foreach ($boards as $board)
@foreach($board->tasks as $task)
<div class="modal fade" id="taskModal{{$task->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">{{$task->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <hr class="mb-6">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <h4 class="mb-4"><i class="fas fa-book"></i>&nbsp; Description</h4>
                        {!!$task->description!!}
                        <hr class="mb-4 mt-4">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <h4><i class="fas fa-users"></i>&nbsp; Assigned Users</h4>
                        @php
                            $arr = $task->assignee;
                            $assignee = explode(",",$arr);
                            $users = DB::table('users')->whereIn('id', $assignee)->get();
                        @endphp
                        @foreach ($users as $user)
                            @if(is_null($user->profile_photo_path))
                                @php
                                    $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                                        return mb_substr($segment, 0, 1);
                                    })->join(''));
                                @endphp
                            <figure class="avatar mr-2 mb-4 mt-2" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
                            @else
                            <figure class="avatar mr-2 mb-4 mt-2">
                                <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                            </figure>
                            @endif
                        @endforeach 
                        <a href="/project/{{$data->id}}/tasks/{{$task->id}}/edit" style="text-decoration: none;color:#6c757d;">
                            <figure class="avatar mr-2 mb-4 mt-2" data-toggle="tooltip" title="Add more user"><i class="fas fa-plus mt-3 ml-3"></i></figure> 
                        </a>
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-briefcase"></i>&nbsp; Project</h4>
                                <a href="/project/{{$data->id}}"><p>{{ $data->title }}</p></a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-shield-alt"></i> Priority</h4>
                                @if($task->priority == "0")
                                <div class="badge badge-info mt-1">Normal</div><br>
                                @elseif($task->priority == "1")
                                <div class="badge badge-warning mt-1">High</div><br>
                                @elseif($task->priority == "2")
                                <div class="badge badge-danger mt-1">Urgent</div><br>
                                @elseif($task->priority == "3")
                                <div class="badge badge-light mt-1">Low</div><br>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-folder-open"></i>&nbsp; Sprint Iteration</h4>
                            @foreach ($sprints as $sprint)
                                @if($task->sprint_id == $sprint->id)
                                    <p>Sprint - {{ $sprint->name }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-flag"></i>&nbsp; Backlog</h4>
                            @foreach ($backlogs as $backlog)
                                @if($task->backlog_id == $backlog->id)
                                    <p>{{ $backlog->name }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-info-circle"></i>&nbsp; Status</h4>
                            @if($task->status == "0")
                            <div class="badge badge-secondary mt-1">In Progress</div><br>
                            @elseif($task->status== "1")
                            <div class="badge badge-success mt-1">Done</div><br>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-calendar-plus"></i>&nbsp; Start Date</h4>
                                <p>{{ $task->start_date }}</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-calendar-times"></i>&nbsp; Due Date</h4>
                                <p>{{ $task->start_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endforeach