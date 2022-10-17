<!-- <a role="button" href="/user/edit/{{ $user->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
<a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a> -->
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <!-- <a role="button" wire:click="edit({{ $user->id }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a> -->
        <a href="/user/{{ $user->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        <a role="button" wire:click="deleteConfirm({{ $user->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>