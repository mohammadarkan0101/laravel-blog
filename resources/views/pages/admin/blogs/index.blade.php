<x-layouts.app title="Data Blogs">

    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <h1 class="m-0">Data Blogs</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('blogs.create') }}" class="btn btn-default">
                        <i class="bi bi-plus-lg"></i> Tambah Blog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT SECTION -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- FLASH MESSAGES -->
                    @if (session('success'))
                        <x-bootstrap.alert type="success" :message="session('success')" />
                    @endif

                    <!-- DATATABLE -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="my-3 table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Judul Blog</th>
                                            <th>Penulis</th>
                                            <th>Status Blog</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DATA BLOGS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: "{{ route('blogs.datatable') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'title', name: 'title' },
                        { data: 'author', name: 'user.name' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            });
        </script>
    @endpush

</x-layouts.app>