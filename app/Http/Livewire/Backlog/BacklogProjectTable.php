<?php

namespace App\Http\Livewire\Backlog;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Backlog;

class BacklogProjectTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Backlog::class;

    public function mount($project)
    {
        $this->project = $project;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions', 'id')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.actions-backlog')->withValue($value)
                ),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.backlog.table.description')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Backlog::where('project_id', $this->project);
    }

    public function deleteConfirm($id)
    {
        $this->deleteId = $id;
        $this->confirm('Are you sure?', [
            'text' => "You won't be able to revert this!",
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'showCanceledButton' => true,
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete',
            'onDismissed' => 'cancel'
        ]);
    } 
    
    public function getListeners()
    {
        return ['delete', 'cancel'];
    }

    public function cancel()
    {
        return $this->alert('info', 'Delete has been cancelled.', ['timerProgressBar' => true,]);
    }

    public function delete()
    {
        Backlog::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
