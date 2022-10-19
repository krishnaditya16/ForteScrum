<x-app-layout>
    <x-slot name="title">{{ __('Task Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Task Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Kanban</h2>
    <p class="section-lead">
        You can manage & view tasks data using the kanban board below.
    </p>

    <div class="row mb-4 mt-2">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" href="#"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="task/kanban"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{ route('board.create') }}"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{ route('task.create') }}"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('pages.task.kanban')

</x-app-layout>