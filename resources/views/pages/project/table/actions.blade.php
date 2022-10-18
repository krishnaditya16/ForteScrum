@php
$current_team = Auth::user()->currentTeam;
@endphp

@if(Auth::user()->ownsTeam($current_team)) 
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="/project/{{ $project->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a role="button" wire:click="deleteConfirm({{ $project->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'project-manager'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="/project/{{ $project->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a role="button" wire:click="deleteConfirm({{ $project->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="#" class="dropdown-item has-icon"><i class="fas fa-vote-yea"></i> Approve Project</a>
    </div>
</div>
@endif