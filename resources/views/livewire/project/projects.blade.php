@php
$current_team = Auth::user()->currentTeam;
@endphp

@if(Auth::user()->ownsTeam($current_team))
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
                    {{ DB::table('projects')->count() }}
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
                    {{ DB::table('projects')->where('status', '2')->count() }}
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
                    {{ DB::table('projects')->where('status', '4')->count() }}
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
                    {{ DB::table('projects')->where('status', '3')->count() }}
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
<h2 class="section-title">Projects List</h2>
<p class="section-lead mb-3">
    You can manage projects data here.
</p>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <!-- <h4>Tambahin tombol create!</h4> -->
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