<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.budget.manage', $project->id) }}" class="dropdown-item has-icon"><i class="fas fa-wallet"></i> Manage Budget</a>
        <a href="{{ route('project.expenses.manage', $project->id) }}" class="dropdown-item has-icon"><i class="fas fa-money-bill-wave-alt"></i> Manage Expenses</a>
        <a href="{{ route('project.invoice.index', $project->id) }}" class="dropdown-item has-icon"><i class="fas fa-file-alt"></i> Manage Invoice</a>
    </div>
</div>