<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Project Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Project</div>
        </div>
    </x-slot>
    <livewire:project.projects>
</x-app-layout>