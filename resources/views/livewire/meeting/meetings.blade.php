@php
$current_team = Auth::user()->currentTeam;
@endphp

<h2 class="section-title">Team Meeting</h2>
<p class="section-lead mb-3">
    Select either one of the project data avalaible below to view meeting data.
</p>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(Auth::user()->ownsTeam($current_team))
                <livewire:meeting.project-meeting-table />
                @elseif(Auth::user()->hasTeamRole($current_team, 'product-owner'))
                <livewire:report.project-report-owner-table />
                @endif
            </div>
        </div>
    </div>
</div>