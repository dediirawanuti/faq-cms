<div class="col-lg-6">

    <div class="modal" id="kategoriModal">
        <div class="modal-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="modal-title"></h5>

                    <!-- Vertical Form -->
                    <form class="row g-3" action="" method="post" id="kategoriForm">
                        <input type="hidden" name="id">
                        <div class="col-12">
                            <label for="nama" class="form-label">Nama Ketegori</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- Vertical Form -->

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Submit form menggunakan Ajax
        $('#kategoriForm').submit(function(e) {
            e.preventDefault();

            var id = $('[name="id"]').val();
            var nama = $('#nama').val();
            var deskripsi = $('#deskripsi').val();

            var url;
            var method;
            if (id == '') {
                url = "<?php echo site_url('kategori/create') ?>";
                method = 'POST';
            } else {
                url = "<?php echo site_url('kategori/update') ?>";
                method = 'PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: {
                    id: id,
                    nama: nama,
                    deskripsi: deskripsi
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: data.message
                        }).then(function() {
                            $('#kategoriForm')[0].reset();
                            $('#kategoriModal').modal('hide');
                            // Reload data tabel atau operasi lain yang diperlukan
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data'
                    });
                }
            });
        });

        // Fungsi untuk menampilkan modal dan mengisi data kategori
        function addKategori() {
            $('[name="id"]').val('');
            $('#nama').val('');
            $('#deskripsi').val('');
            $('.modal-title').text('Tambah Kategori');
            $('#kategoriModal').modal('show');
        }

        // Fungsi untuk menampilkan modal dan mengisi data kategori yang akan diupdate
        function editKategori(id, nama, deskripsi) {
            $('[name="id"]').val(id);
            $('#nama').val(nama);
            $('#deskripsi').val(deskripsi);
            $('.modal-title').text('Edit Kategori');
            $('#kategoriModal').modal('show');
        }
    });
</script>