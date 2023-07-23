<div class="container mt-5">

    <!-- Form Tambah Pengguna -->
    <div id="form_add">
        <h3>Tambah Pengguna</h3>
        <form id="add_user_form" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" name="nama" placeholder="Nama" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="hak_akses" required>
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <input type="file" class="form-control-file" name="foto_profil" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <h3>Daftar Pengguna</h3>
    <table id="user_table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Hak Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            responsive: true,
            searching: true,
            ajax: "<?= base_url('user/datatables'); ?>",
            order: [],
            // "ajax": "<?= base_url('user/datatables'); ?>",
            "columns": [{
                    "data": "id",
                    orderable: false,
                },
                {
                    "data": "nama"
                },
                {
                    "data": "username"
                },
                {
                    "data": "hak_akses"
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        var id = full.id;
                        return '<a href="#" class="btn btn-danger delete" data-id="' + full.id + '">Hapus</a>' +
                            '<a href="<?php echo base_url('user/form_edit/'); ?>' + id + '" class="btn btn-primary edit" data-id="' + id + '">Edit</a>';
                    }
                }
            ]
        });

        // Menambahkan pengguna baru
        $('#add_user_form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url('user/add'); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "true") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Pengguna berhasil ditambahkan!',
                            onClose: function() {
                                $('#add_user_form')[0].reset();
                                table.ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!'
                        });
                    }
                }
            });
        });

        // Mengedit pengguna
        $('#user_table tbody').on('click', '.edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // Mendapatkan data pengguna berdasarkan ID menggunakan permintaan AJAX
            window.location.href = "<?php echo base_url('user/form_edit/'); ?>" + id;
        });

        // Menyimpan perubahan pengguna setelah edit
        $('#edit_user_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo base_url('user/update'); ?>",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == "true") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Pengguna berhasil diedit!',
                            onClose: function() {
                                $('#editModal').modal('hide');
                                table.ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!'
                        });
                    }
                }
            });
        });

        // Menghapus pengguna
        $('#user_table tbody').on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Anda yakin ingin menghapus pengguna ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo base_url('user/delete'); ?>",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data == "true") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Pengguna berhasil dihapus!',
                                    onClose: function() {
                                        table.ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan!'
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>