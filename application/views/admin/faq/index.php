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
                                <h5 class="card-title">Manajemen FAQ</h5>
                            </div>
                            <div class="col-auto m-3">
                                <button type="button" data-toggle="modal" data-target="#addFaqModal" class="btn btn-primary btn-modaladdfaq">Tambah Faq</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="faq_tabel">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Pertanyaan</th>
                                            <th scope="col">Jawaban</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Authors</th>
                                            <th scope="col">Status</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <!-- Data rows will be dynamically added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-modaladdfaq', function() {
            $.ajax({
                url: '<?= base_url('faq/form_add'); ?>',
                success: function(response) {
                    $('body').append(response);
                    var modal = new bootstrap.Modal($('#addFaqModal'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $('#faq_tabel').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            responsive: true,
            searching: true,
            ajax: "<?= base_url('faq/datatables'); ?>",
            order: [],
            columns: [{
                    data: "id"
                },
                {
                    data: "quesion"
                },
                {
                    data: "answer"
                },
                {
                    data: "kategori_id",
                },
                {
                    data: "authors"
                },
                {
                    data: "status"
                },
                {
                    data: null,
                    render: function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="#" class="btn btn-danger delete" data-id="' + full.id + '">Hapus</a>' +
                            '<a href="<?= base_url('faq/form_edit/'); ?>' + id + '" class="btn btn-primary edit" data-id="' + id + '">Edit</a>';
                    }
                }
            ]
        });
    });
</script>