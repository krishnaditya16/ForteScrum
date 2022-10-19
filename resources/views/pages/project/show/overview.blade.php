<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Client : {{ $client->name }}
                    <h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4>Product Owner</h4>
                        @if($po->isNotEmpty())
                            @foreach ($po as $user)
                                @if(is_null($user->profile_photo_path))
                                    @php
                                        $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                                        return mb_substr($segment, 0, 1);
                                        })->join(''));
                                    @endphp
                                <figure class="avatar mr-2 mb-4 mt-2" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
                                @else
                                <figure class="avatar mr-2 mb-4 mt-2">
                                    <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                                </figure>
                                @endif
                            @endforeach
                        @else
                        <p class="mb-4">Team has no product owner</p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <h4>Project Manager</h4>
                        @if($pm->isNotEmpty())
                            @foreach ($pm as $user)
                                @if(is_null($user->profile_photo_path))
                                    @php
                                        $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                                        return mb_substr($segment, 0, 1);
                                        })->join(''));
                                    @endphp
                                <figure class="avatar mr-2 mb-4 mt-2" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
                                @else
                                <figure class="avatar mr-2 mb-4 mt-2">
                                    <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                                </figure>
                                @endif
                        @endforeach
                        @else
                        <p class="mb-4">Team has no project manager</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <h4>Assigned Team</h4>
                        @if($tm->isNotEmpty())
                            @foreach ($tm as $user)
                                @if(is_null($user->profile_photo_path))
                                    @php
                                        $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                                        return mb_substr($segment, 0, 1);
                                        })->join(''));
                                    @endphp
                                <figure class="avatar mr-2 mb-4 mt-2" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
                                @else
                                <figure class="avatar mr-2 mb-4 mt-2">
                                    <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                                </figure>
                                @endif
                            @endforeach
                        @else
                        <p class="mb-4">Team has no member</p>
                        @endif
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <h4>Start Date</h4>
                        <p>{{ $project->start_date }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <h4>Due Date</h4>
                        <p>{{ $project->end_date }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <h4>Category</h4>
                        @if($project->category == "0")
                        <p>Web Development</p>
                        @elseif($project->category == "1")
                        <p>Mobile App Development</p>
                        @elseif($project->category == "2")
                        <p>Graphic Design</p>
                        @elseif($project->category == "3")
                        <p>Content Marketing</p>
                        @elseif($project->category == "4")
                        <p>Other</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <h4>Status</h4>
                        @if($project->status == "0")
                        <div class="badge badge-secondary">Waiting Approval</div>
                        @elseif($project->status == "1")
                        <div class="badge badge-danger">Rejected</div>
                        @elseif($project->status == "2")
                        <div class="badge badge-info">In Progress</div>
                        @elseif($project->status == "3")
                        <div class="badge badge-success">Completed</div>
                        @elseif($project->status == "4")
                        <div class="badge badge-warning">On Hold</div>
                        @elseif($project->status == "5")
                        <div class="badge badge-danger">Cancelled</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Title : {{ $project->title }}
                    <h4>
            </div>
            <div class="card-body">
                <h4 class="mb-2">Progress</h4>
                <div class="progress" data-toggle="tooltip" title="{{ $project->progress }}%">
                    <div class="progress-bar bg-success" role="progressbar" data-width="{{ $project->progress }}%" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mt-2">Current progress of {{$project->title}} : {{$project->progress}}%</p>

                @php $current_team = Auth::user()->currentTeam; @endphp
                @if(Auth::user()->hasTeamRole($current_team, 'project-manager'))
                    <a href="{{ route('project.edit', $project->id) }}" class="btn btn-icon icon-left btn-primary mt-2" type="button" @if($project->status == 0) onclick="alert()->warning('Warning!','Project need to be approved by product owner first!');" @endif><i class="fas fa-edit"></i>Update Progress</a>
                @endif
                <hr class="mb-4 mt-4">

                <h4>Proposal</h4>
                <p>{{ $project->proposal }}</p>
                <a href="{{ route('project.proposal', $project->id) }}" class="btn btn-icon icon-left btn-primary mt-2" type="button"><i class="fas fa-download"></i>Download File</a>
                <button class="btn btn-primary mt-2" data-toggle="modal" data-target="#proposalModal"><i class="fas fa-eye"></i> View File</button>

                <hr class="mb-4 mt-4">

                <h4>Platform</h4>

                <div class="form-group mt-2">
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item" data-toggle="tooltip" title="Default">
                            <input type="radio" @if($project->platform == "0") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-laptop-code"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Web">
                            <input type="radio" @if($project->platform == "1") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-globe"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Mobile">
                            <input type="radio" @if($project->platform == "2") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-mobile"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Other">
                            <input type="radio" @if($project->platform == "3") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-unlink"></i></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
