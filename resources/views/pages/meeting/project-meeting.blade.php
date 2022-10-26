<x-app-layout>
    <x-slot name="title">{{ $project->title }} - {{ __('Meeting') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('meeting.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $project->title }} - {{ __('Meeting') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Meeting</div>
        </div>
    </x-slot>

    <h2 class="section-title">Meeting Data</h2>
    <p class="section-lead mb-3">
        You can view avalaible meeting from {{ $project->title }} here.
    </p>

    <div class="card">
        <div class="card-header">
            <div class="card-header-action">
                <a href="{{ route('project.meeting.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
            </div>
        </div>
        <div class="card-body">
            <livewire:meeting.meeting-table project="{{ $project->id }}" />
        </div>
    </div>

</x-app-layout>