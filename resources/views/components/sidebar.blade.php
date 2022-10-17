@php
$current_team = Auth::user()->currentTeam;

if(Auth::user()->ownsTeam($current_team)) {
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
        [
            "href" => [
                [
                    "section_text" => "User",
                    "section_list" => [
                        ["href" => "user.index", "text" => "All Users"],
                        ["href" => "client.index", "text" => "Clients Data"],
                        ["href" => "client.index", "text" => "Client Users"],
                    ]
                ]
            ],
            "text" => "User",
            "is_multi" => true,
        ],
        [
            "href" => [
                [
                    "section_text" => "Project",
                    "section_list" => [
                        ["href" => "project.index", "text" => "Project List"],
                        ["href" => "backlog.index", "text" => "Backlog"],
                        ["href" => "sprint.index", "text" => "Sprint"],
                        ["href" => "task.index", "text" => "Task"],
                    ]
                ]
            ],
            "text" => "Project",
            "is_multi" => true,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if(Auth::user()->hasTeamRole($current_team, 'guest')){
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if(Auth::user()->hasTeamRole($current_team, 'project-manager')){
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if(Auth::user()->hasTeamRole($current_team, 'product-owner')){
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
    ];
    $navigation_links = array_to_object($links);
} else if(Auth::user()->hasTeamRole($current_team, 'team-member')){
    $links = [
        [
            "href" => "dashboard",
            "text" => "Dashboard",
            "is_multi" => false,
        ],
    ];
    $navigation_links = array_to_object($links);
} 
@endphp

<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                DB<!-- <img class="d-inline-block" width="32px" height="30.61px" src="" alt=""> -->
            </a>
        </div>
        @foreach ($navigation_links as $link)
        <ul class="sidebar-menu">
            <li class="menu-header">{{ $link->text }}</li>
            @if (!$link->is_multi)
            <li class="{{ Request::routeIs($link->href) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($link->href) }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @else
                @foreach ($link->href as $section)
                    @php
                    $routes = collect($section->section_list)->map(function ($child) {
                        return Request::routeIs($child->href);
                    })->toArray();

                    $is_active = in_array(true, $routes);
                    @endphp

                    <li class="dropdown {{ ($is_active) ? 'active' : '' }}">
                        @if($section->section_text == 'User')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>{{ $section->section_text }}</span></a>
                        @elseif($section->section_text == 'Project')
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i> <span>{{ $section->section_text }}</span></a>
                        @endif
                        <ul class="dropdown-menu">
                            @foreach ($section->section_list as $child)
                                <li class="{{ Request::routeIs($child->href) ? 'active' : '' }}"><a class="nav-link" href="{{ route($child->href) }}">{{ $child->text }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        @endforeach
    </aside>
</div>