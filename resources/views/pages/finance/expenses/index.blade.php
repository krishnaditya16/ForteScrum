<x-app-layout>
    <x-slot name="title">{{ __('Project Expenses') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Project Expenses') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Manage Expenses</div>
        </div>
    </x-slot>

    <h2 class="section-title">Project Expenses</h2>
    <p class="section-lead mb-3">
        Select either one of the project data avalaible below to view project expenses.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $project->title }} - Expenses</h4>
                    <div class="card-header-action">
                        <a href="{{ route('project.expenses.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    </div>
                </div>
                @livewire('expense.expense-project', ['project' => $project])
            </div>
        </div>
    </div>

</x-app-layout>