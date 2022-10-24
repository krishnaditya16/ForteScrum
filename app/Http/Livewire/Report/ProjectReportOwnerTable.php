<?php

namespace App\Http\Livewire\Report;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectReportOwnerTable extends DataTableComponent
{
    protected $model = Project::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.project.table.actions')->with(['project' => $row])),
            Column::make("Title", "title")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Client", "client.name")
                ->searchable()
                ->sortable(),
            Column::make("Team", "team.name")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Due date", "end_date")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        $client = Auth::user()->client_id;

        return Project::query()
            ->where('projects.client_id', $client)
            ->select('projects.id', 'projects.title', 'clients.name', 'teams.name', 'projects.end_date', 'projects.progress', 'projects.status');
    }
}
