<section class="hero-video-section">
    <div class="hero-overlay"></div>
    <div class="container h-100">
        <div class="row align-items-center h-100 py-5">

            <!-- Кнопка видео -->
            <div class="col-lg-3 col-md-2 text-center">
                <a href="https://www.youtube.com/watch?v=jnLSYfObARA"
                   class="video-play-btn"
                   data-bs-toggle="modal"
                   data-bs-target="#videoModal">
                    <i class="fas fa-play"></i>
                </a>
            </div>

            <!-- Текст -->
            <div class="col-lg-6 col-md-8">
                <h2 class="hero-title mb-4">
                    Создаем <span>комфорт и уют</span> в вашем доме или офисе
                </h2>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/contacts/" class="btn hero-btn">Сертификаты <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="/contacts/" class="btn hero-btn">Протоколы испытаний <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Модальное окно с видео -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-black border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="youtubeFrame"
                            src=""
                            data-src="https://www.youtube.com/embed/jnLSYfObARA?autoplay=1"
                            title="YouTube video"
                            allowfullscreen
                            allow="autoplay; encrypted-media">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
 

<script>
jQuery(document).ready(function($) {
    $('#videoModal').on('show.bs.modal', function() {
        var src = $('#youtubeFrame').data('src');
        $('#youtubeFrame').attr('src', src);
    });

    $('#videoModal').on('hidden.bs.modal', function() {
        $('#youtubeFrame').attr('src', '');
    });
});
</script>