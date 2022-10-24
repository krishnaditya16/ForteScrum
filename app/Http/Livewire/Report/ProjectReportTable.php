<?php

namespace App\Http\Livewire\Report;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Project;

class ProjectReportTable extends DataTableComponent
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
                ->label(fn ($row, Column $column) => view('pages.report.table.actions')->with(['project' => $row])),
            Column::make("Id", "id")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Title", "title")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Client", "client.name")
                ->searchable()
                ->sortable(),
            Column::make("Team", "team.name")
                ->searchable()
                ->sortable(),
            Column::make("Due date", "end_date")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
        ];
    }
}
