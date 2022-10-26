@php
$team = Auth::user()->currentTeam;
@endphp

@if(Auth::user()->ownsTeam($team) || Auth::user()->hasTeamRole($team, 'team-member'))
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-th-list"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>All</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-info">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>In Progress</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '2')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-hand-paper"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>On Hold</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '4')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Completed</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '3')->count() }}
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($team, 'product-owner'))
<h2 class="section-title">Projects List</h2>
<p class="section-lead mb-3">
    You can manage projects data here.
</p>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    @if(Auth::user()->ownsTeam($team))
                    <a href="{{ route('project.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    @elseif(Auth::user()->hasTeamRole($team, 'product-owner') || Auth::user()->hasTeamRole($team, 'team-member'))
                    <h4>My Projects</h4>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(Auth::user()->ownsTeam($team) || Auth::user()->hasTeamRole($team, 'team-member'))
                <livewire:project.project-table />
                @elseif(Auth::user()->hasTeamRole($team, 'product-owner'))
                <livewire:project.project-owner-table />
                @endif
            </div>
        </div>
    </div>
</div>