@php
$backlog = DB::table('backlogs')->where('sprint_id', $value)->get();
$task = DB::table('tasks')->where('sprint_id', $value)->get();
$sprint = DB::table('sprints')->where('id', $value)->first();
@endphp

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{$this->project}}/sprint/{{$value}}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        @if($sprint->status == "0")
        <form action="/project/{{$this->project}}/sprint/{{$value}}/sprint-status" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ $value }}" name="sprint_id">
            <input type="hidden" value="1" name="status">
            <a href="javascript:void(0)" class="dropdown-item has-icon link-dropdown-kanban"  onclick="return confirm('Are you sure you want to close this sprint?')">
                <i class="fas fa-door-closed"></i> 
                Close Sprint
            </a>
        </form>
        @else
        <form action="/project/{{$this->project}}/sprint/{{$value}}/sprint-status" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" value="{{ $value }}" name="sprint_id">
            <input type="hidden" value="0" name="status">
            <a href="javascript:void(0)" class="dropdown-item has-icon link-dropdown-kanban"  onclick="return confirm('Are you sure you want to open this sprint?')">
                <i class="fas fa-door-open"></i> 
                Open Sprint
            </a>
        </form>
        @endif
        <div class="dropdown-divider"></div>
        @if(!empty($backlog->first()) || !empty($task->first()))
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="Action is disabled for this sprint."><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $value }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
        @endif
    </div>
</div>