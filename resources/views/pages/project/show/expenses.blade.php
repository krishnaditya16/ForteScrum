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