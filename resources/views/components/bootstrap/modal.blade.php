@props(['id', 'action'])

<div class="modal fade" id="confirmDeleteModal{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $id }}">
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Batal
                </button>
                <form action="{{ $action }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
