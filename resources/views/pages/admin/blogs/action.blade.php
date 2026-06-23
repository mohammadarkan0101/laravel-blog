<div class="d-flex">
    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-default btn-sm rounded-circle mr-1">
        <i class="bi bi-pencil"></i>
    </a>

    <button type="button" class="btn btn-danger btn-sm rounded-circle" data-toggle="modal" data-target="#confirmDeleteModal{{ $blog->id }}">
        <i class="bi bi-trash"></i>
    </button>

    <x-bootstrap.modal :id="$blog->id" :action="route('blogs.destroy', $blog->id)" />
</div>