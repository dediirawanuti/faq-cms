<div class="modal" id="addFaqModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah FAQ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addFaqForm">
                    <div class="form-group mb-2">
                        <label for="quesion">Pertanyaan:</label>
                        <input type="text" class="form-control" id="quesion" name="quesion">
                    </div>
                    <div class="form-group mb-2">
                        <label for="answer">Jawaban:</label>
                        <textarea class="form-control" id="answer" name="answer"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="kategori_id">Kategori:</label>
                        <select class="form-control" id="kategori_id" name="kategori_id">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $row) : ?>
                                <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="authors">Authors:</label>
                        <input type="text" class="form-control" id="authors" name="authors">
                    </div>
                    <div class="form-group mb-2">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="keyword">Keywords:</label>
                        <input type="text" class="form-control" id="keyword" name="keyword">
                    </div>
                    <div class="form-group mb-2">
                        <label for="seacrh_key">Seacrh_key:</label>
                        <input type="text" class="form-control" id="search_key" name="search_key">
                    </div>
                    <div class="d-flex justify-space-between mb-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#addFaqForm').submit(function(e) {
            e.preventDefault(); // Mencegah reload halaman saat submit form
            var formData = $(this).serialize(); // Mengambil data form

            $.ajax({
                url: '<?= base_url('faq/store'); ?>', // Ganti dengan URL yang sesuai untuk memproses form
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Menampilkan SweetAlert setelah berhasil menyimpan FAQ
                    Swal.fire({
                        icon: 'success',
                        title: 'FAQ berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = '<?= base_url('faq'); ?>';
                    });
                    // Tambahkan kode lain yang ingin Anda lakukan setelah menyimpan FAQ
                },
                error: function(xhr, status, error) {
                    // Tambahkan kode untuk menangani error saat melakukan request Ajax
                    console.log(error);
                }
            });
        });
    });
</script>