    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="tanya.imamahmad.my.id" class="logo d-flex align-items-center w-auto">
                                    <img src="<?= base_url(); ?>/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">FAQ CMS</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login Panel</h5>
                                        <p class="text-center small">Enter your username & password to akses Panel Admin</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate method="post" action="" id="loginForm">

                                        <div class="col-12">
                                            <label for="email_username" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email_username" class="form-control" id="email_username" required>
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="Password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                    <div id="error-message"></div>

                                    <a href="<?= base_url(); ?>auth/form_registrasi">registrasi</a>

                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                Designed by <a href="https://imamahmad.my.id">Kopi Koding</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '<?php echo site_url("auth/login"); ?>',
                    type: 'post',
                    data: $('#loginForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            // Redirect to the specified page
                            window.location.href = response.redirect;
                        } else {
                            // Display error message
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>