<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.expenses.status.edit', ['id'=>$this->project, 'expense'=>$value]) }}" class="dropdown-item has-icon"><i class="fas fa-sync-alt"></i> Update Status</a>
        <a href="{{ route('project.expenses.edit', ['id'=>$this->project, 'expense'=>$value]) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit Expenses</a>
        <div class="dropdown-divider"></div>     
        <a role="button" wire:click="deleteConfirm({{ $value }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>