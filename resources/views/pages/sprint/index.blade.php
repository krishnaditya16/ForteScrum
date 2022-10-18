<x-app-layout>
    <x-slot name="title">{{ __('Sprint Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Sprint Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Sprint</div>
        </div>
    </x-slot>
    <livewire:sprint.sprints>
</x-app-layout>