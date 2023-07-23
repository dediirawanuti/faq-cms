<form id="registerForm" method="post" action="">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<script>
    $(document).ready(function() {
        $('#registerForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?php echo site_url("auth/register"); ?>',
                type: 'post',
                data: $('#registerForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Registrasi berhasil
                        swal({
                            title: 'Registrasi Berhasil',
                            text: response.message,
                            icon: 'success'
                        }).then(function() {
                            // Redirect ke halaman login atau halaman lainnya
                            window.location.href = '<?php echo site_url("auth/login"); ?>';
                        });
                    } else {
                        // Registrasi gagal, tampilkan pesan error
                        swal({
                            title: 'Registrasi Gagal',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>