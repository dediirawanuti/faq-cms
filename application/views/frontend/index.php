<div class="row">
    <div class="col-xl-12 pa-0">
        <div class="faq-search-wrap bg-teal-light-3">
            <div class="container">
                <h1 class="display-5 text-white mb-20">Ask a question or browse by category below.</h1>
                <div class="form-group w-100 mb-0">
                    <div class="input-group">
                        <input class="form-control form-control-lg filled-input bg-white" placeholder="Search by keywords" type="text">
                        <div class="input-group-append">
                            <span class="input-group-text"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-sm-60 mt-30">
            <div class="hk-row">
                <div class="col-xl-4">
                    <div class="card">
                        <h6 class="card-header">
                            Category
                        </h6>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($kategori as $row) : ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <a href="#" class="kategori-link" data-kategori-id="<?= $row['id'] ?>">
                                        <?= $row['nama'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card card-lg">
                        <h3 class="card-header border-bottom-0">
                            FAQ
                        </h3>
                        <?php foreach ($faq as $index => $faqs) : ?>
                            <div class="accordion accordion-type-2 accordion-flush" id="accordion_<?php echo $index; ?>">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between activestate" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $index; ?>">
                                        <a role="button"><?= $faqs['quesion']; ?></a>
                                    </div>
                                    <div id="collapse_<?php echo $index; ?>" class="collapse" data-parent="#accordion_<?php echo $index; ?>">
                                        <div class="card-body pa-15"><?= $faqs['answer']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.kategori-link').click(function(e) {
            e.preventDefault();
            var kategoriId = $(this).data('kategori_id');
            var keywords = $('#search-input').val();
            loadFaqByKategori(kategoriId, keywords);
        });

        function loadFaqByKategori(kategoriId, keywords) {
            $.ajax({
                url: '<?= base_url('home/get_by_kategori'); ?>',
                type: 'POST',
                data: {
                    kategoriId: kategoriId,
                    keywords: keywords
                },
                success: function(response) {
                    // Tampilkan data FAQ sesuai dengan kategori yang dipilih
                    var data = response.data;
                    displayFaq(data);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function displayFaq(data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html += '<div class="accordion accordion-type-2 accordion-flush" id="accordion_' + i + '">';
                html += '<div class="card">';
                html += '<div class="card-header d-flex justify-content-between activestate">';
                html += '<a role="button" data-toggle="collapse" href="#collapse_' + i + 'i" aria-expanded="true">' + data[i].quesion + '</a>';
                html += '</div>';
                html += '<div id="collapse_' + i + 'i" class="collapse show" data-parent="#accordion_' + i + '" role="tabpanel">';
                html += '<div class="card-body pa-15">' + data[i].answer + '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }
            $('#faq-content').html(html);
        }
    });
</script>