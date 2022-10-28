<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-turbolinks="false" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <h1 class="font-weight-bold text-2xl text-white">{{ config('app.name', 'Laravel') }}</h1>
        {{-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </div> --}}
    </form>
    <ul class="navbar-nav navbar-right">
        @include('notification.notify')
        <img class="rounded-circle mr-1" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" width="32px">
        <li class="dropdown dropdown-nav-user">
            <a href="#" data-turbolinks="false" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (!is_null(Auth::user()))
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
            </a>
            @else
            <div class="d-sm-none d-lg-inline-block">Hi, Welcome</div></a>
            @endif
            <div class="dropdown-menu dropdown-menu-right">
                <!-- User & Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Profile & Team') }}
                </div>
                <a href="{{ route('profile.show') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user"></i> User Profile
                </a>
                <!-- Team Settings -->
                @php
                    $team = Auth::user()->currentTeam;
                @endphp
                @if(Auth::user()->hasTeamRole($team, 'project-manager') || Auth::user()->hasTeamRole($team, 'product-owner') || Auth::user()->ownsTeam($team))
                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="dropdown-item has-icon">
                    <i class="fas fa-users-cog"></i> Team Settings
                </a>
                @endif
                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <a href="{{ route('teams.create') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> Create New Team
                </a>
                @endcan

                <div class="dropdown-divider"></div>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <form method="POST" action="/current-team">
                    @method('PUT')
                    @csrf
                    <!-- Hidden Team ID -->
                    <input type="hidden" name="team_id" value="{{ $team->id }}">

        <li class="flex">
            <a class="dropdown-item has-icon" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-check-circle @if (Auth::user()->isCurrentTeam($team)) text-green-400 @else text-gray-400 @endif"></i>
                <span>{{ $team->name }}</span>
            </a>
        </li>
        </form>
        @endforeach
        @endif

        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}" id="logout">
            @csrf

            {{-- <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();this.closest('form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a> --}}

            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" data-confirm="Are You Sure?|You will be logged out from the system. Do you want to continue?" data-confirm-yes="document.getElementById('logout').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </form>
        </div>
        </li>
    </ul>
</nav>