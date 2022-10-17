<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Backlog Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Backlog</div>
        </div>
    </x-slot>
    
</x-app-layout>