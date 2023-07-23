<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between mb-2">
                            <div class="col-auto">
                                <h5 class="card-title">Manajemen Kategori</h5>
                            </div>
                            <div class="col-auto m-3">
                                <button type="button" class="btn btn-primary" onclick="window.addKategori()">Tambah Kategori</button>
                            </div>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="datatables">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            responsive: true,
            searching: true,
            "ajax": "<?php echo base_url('kategori/datatables'); ?>",
            order: [],
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "deskripsi"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-sm btn-primary" onclick="editKategori(' + row.id + ', \'' + row.nama + '\', \'' + row.deskripsi + '\')">Edit</button>' +
                            '<button type="button" class="btn btn-sm btn-danger" onclick="deleteKategori(' + row.id + ')">Delete</button>';
                    }
                }
            ]
        });
    });
</script>