@php
$current_team = Auth::user()->currentTeam;
@endphp

<div class="container-fluid kanban">
    <div class="row flex-row flex-nowrap">
        @forelse ($boards as $board)
        <div class="col-12 col-lg-3 kanban-list card card-primary">
            <div class="kanban-title dropleft"> {{ $board->title }} <span class="badge badge-primary ml-1">{{ count($board->tasks->where('status', 0)) }}</span>
                <button class="btn float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu dropleft">
                    <a class="dropdown-item" href="/project/{{$data->id}}/tasks/edit-board/{{$board->id}}"><i class="fas fa-edit"></i>&nbsp; Edit Board</a>
                    @if(empty($board->tasks->first()))
                    <form action="{{ route('project.board.destroy', $board->id) }}" method="POST" id="deleteBoard">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="dropdown-item has-icon btn-outline-danger btn-dropdown-kanban" data-confirm="Are You Sure?|This board will be deleted. Do you want to continue?" data-confirm-yes="document.getElementById('deleteBoard').submit();">
                                <i class="fas fa-trash"></i> Delete Board
                            </button>
                        </form>
                    @else
                    <a class="dropdown-item" style="color:grey" data-toggle="tooltip" data-placement="bottom" title="Action is disabled for this board."><i class="fas fa-trash"></i>&nbsp; Delete Board</a>
                    @endif
                </div>
            </div>
            @forelse($board->tasks->where('status', 0) as $task)
                
                <a href="" data-toggle="modal" data-target="#taskModal{{ $task->id }}" style="text-decoration: none;color:#6c757d;">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $task->title }}</h4>
                        </div>
                        <div class="card-body" data-toggle="tootltip" title="Click to show detail!">
                            @if($task->priority == "0")
                            <div class="badge badge-info mb-2">Normal</div><br>
                            @elseif($task->priority == "1")
                            <div class="badge badge-warning mb-2">High</div><br>
                            @elseif($task->priority == "2")
                            <div class="badge badge-danger mb-2">Urgent</div><br>
                            @elseif($task->priority == "3")
                            <div class="badge badge-light mb-2">Low</div><br>
                            @endif
                            <b>Client:</b>
                            @php
                            $myArray = array();
                            foreach ($owner as $user){
                            $myArray[] = '<span>'.ucfirst($user->name).'</span>';
                            }
                            echo implode( ', ', $myArray ).'<br>';
                            @endphp
                            <b>Created:</b> {{date('d-m-Y', strtotime($task->created_at));}}<br>
                            <b>Due Date:</b> {{date('d-m-Y', strtotime($task->end_date));}}<br>
                        </div>
                </a>
                @if(Auth::user()->ownsTeam($current_team) || Auth::user()->hasTeamRole($current_team, 'project-manager'))
                <div class="card-footer bg-whitesmoke">
                    <form action="{{ route('project.task.destroy', $task->id) }}" method="POST" style="display: inline-block;" id="deleteTask">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger has-icon" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('deleteTask').submit();">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <div class="dropdown float-right">
                        <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <form action="{{ route('project.task.status', $task->id) }}" method="post" id="doneTask">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="1" name="status">
                                <a href="#" class="dropdown-item has-icon btn-outline-success" data-confirm="Are You Sure?|This task will be marked as done. Do you want to continue?" data-confirm-yes="document.getElementById('doneTask').submit();">
                                    <i class="fas fa-check"></i> Mark as Done 
                                </a>
                            </form>
                            <a href="/project/{{$data->id}}/tasks/{{$task->id}}/record" class="dropdown-item has-icon"><i class="fas fa-user-clock"></i> Record Timesheet</a>
                            <form action="{{ route('project.task.reminder') }}" method="post" id="remindTask">
                                @csrf
                                <input type="hidden" value="{{$task->id}}" name="task_id">
                                <a href="#" class="dropdown-item has-icon" data-confirm="Are You Sure?|You will send a task reminder email to all task assignee. Do you want to continue?" data-confirm-yes="document.getElementById('remindTask').submit();">
                                    <i class="fas fa-bell"></i> Task Reminder</a>
                                </a>
                            </form>
                            <a href="/project/{{$data->id}}/tasks/{{$task->id}}/edit" class="dropdown-item has-icon"><i class="fas fa-edit"></i> Edit Task</a>
                            <div class="dropdown-divider"></div>
                            @foreach($options as $option)
                            <form action="{{ route('project.task.move', $task->id) }}" method="post" id="moveTask">
                                @csrf
                                @method('PUT')
                                @if($option->id != $board->id)
                                <input type="hidden" value="{{ $option->id }}" name="board_id">
                                <a href="javascript:void(0)" class="dropdown-item has-icon link-dropdown-kanban"><i class="fas fa-arrows-alt"></i> Move to {{ $option->title }}</a>
                                @endif
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->hasTeamRole($current_team, 'team-member'))
            <div class="card-footer bg-whitesmoke">
                    <form action="{{ route('project.task.destroy', $task->id) }}" method="POST" style="display: inline-block;" id="deleteTask">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger has-icon" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('deleteTask').submit();">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <div class="dropdown float-right">
                        <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <form action="{{ route('project.task.status', $task->id) }}" method="post" id="doneTask">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="1" name="status">
                                <a href="#" class="dropdown-item has-icon btn-outline-success link-dropdown-kanban" data-confirm="Are You Sure?|This task will be marked as done. Do you want to continue?" data-confirm-yes="document.getElementById('doneTask').submit();">
                                    <i class="fas fa-check"></i> Mark as Done 
                                </a>
                            </form>
                            <a href="/project/{{$data->id}}/tasks/{{$task->id}}/record" class="dropdown-item has-icon"><i class="fas fa-user-clock"></i> Record Timesheet</a>
                            <a href="/project/{{$data->id}}/tasks/{{$task->id}}/edit" class="dropdown-item has-icon"><i class="fas fa-edit"></i> Edit Task</a>
                            <div class="dropdown-divider"></div>
                            @foreach($options as $option)
                            <form action="{{ route('project.task.move', $task->id) }}" method="post" id="moveTask">
                                @csrf
                                @method('PUT')
                                @if($option->id != $board->id)
                                <input type="hidden" value="{{ $option->id }}" name="board_id">
                                <a href="javascript:void(0)" class="dropdown-item has-icon link-dropdown-kanban"><i class="fas fa-arrows-alt"></i> Move to {{ $option->title }}</a>
                                @endif
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif     

        @empty
        <div class="alert empty-kanban alert-has-icon">
            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
            <div class="alert-body">
                <div class="alert-title">Empty</div>
                There is no task for this board.
            </div>
        </div>
        @endforelse
    </div>
    @empty
        <div class="card col-12">
            <div class="card-header">
                <h4>Empty Board</h4>
            </div>
            <div class="card-body">
                <div class="empty-state" data-height="400" style="height: 400px;">
                    <div class="empty-state-icon">
                        <i class="fas fa-question"></i>
                    </div>
                    <h2>We couldn't find any boards related to the project.</h2>
                    <p class="lead">
                        Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                    </p>
                    <a href="/project/{{$data->id}}/create-board" class="btn btn-primary mt-4">Create new One</a>
                </div>
            </div>
        </div>
    @endforelse
</div>