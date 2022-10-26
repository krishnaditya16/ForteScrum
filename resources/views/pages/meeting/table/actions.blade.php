@php
$current_team = Auth::user()->currentTeam;
$backlog = DB::table('backlogs')->where('project_id', $project->id)->get();
$sprint = DB::table('sprints')->where('project_id', $project->id)->get();
$task = DB::table('tasks')->where('project_id', $project->id)->get();
@endphp

@if(Auth::user()->ownsTeam($current_team)) 
<div class="dropdown">
    <a href="/project/{{ $project->id }}/meeting" class="btn btn-outline-dark has-icon"><i class="fas fa-calendar"></i>&nbsp; View Meeting</a>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'project-manager'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-file-alt"></i> View Report</a>
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-print"></i> Print Report</a>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-file-alt"></i> View Report</a>
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-print"></i> Print Report</a>
    </div>
</div>
@endif