@php
$current_team = Auth::user()->currentTeam;
@endphp

<h2 class="section-title">Projects List</h2>
<p class="section-lead mb-3">
    You can manage project reports here.
</p>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    @if(Auth::user()->ownsTeam($current_team))
                    <a href="{{ route('project.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    @elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
                    <h4>My Projects</h4>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(Auth::user()->ownsTeam($current_team))
                <livewire:project.project-table />
                @elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
                <livewire:project.project-owner-table />
                @endif
            </div>
        </div>
    </div>
</div>