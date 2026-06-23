<div class="d-flex">
    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default btn-sm rounded-circle mr-1">
        <i class="bi bi-pencil"></i>
    </a>

    <button type="button" class="btn btn-danger btn-sm rounded-circle" data-toggle="modal" data-target="#confirmDeleteModal{{ $user->id }}">
        <i class="bi bi-trash"></i>
    </button>

    <x-bootstrap.modal :id="$user->id" :action="route('users.destroy', $user->id)" />
</div>