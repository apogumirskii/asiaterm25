<section class="news-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h6 class="section-subheading">Новости</h6>
            <h2 class="section-heading">Последние статьи</h2>
        </div>

        <?php
        $news_query = new WP_Query([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        ?>

        <?php if ($news_query->have_posts()) : ?>
        <div class="row g-4">

            <?php
            $index = 0;
            while ($news_query->have_posts()) : $news_query->the_post();
            $thumb = get_the_post_thumbnail_url(get_the_ID(), 'catalog-thumb');
            $cats  = get_the_category();
            $cat   = $cats ? $cats[0] : null;
            ?>

            <?php if ($index === 0) : ?>
            <!-- Большой первый пост -->
            <div class="col-lg-6">
                <article class="news-card-large h-100">
                    <a href="<?php the_permalink(); ?>" class="news-img-wrap d-block">
                        <?php if ($thumb) : ?>
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <?php if ($cat) : ?>
                            <span class="news-cat"><?php echo esc_html($cat->name); ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="news-body">
                        <div class="news-meta">
                            <span><i class="fas fa-calendar-alt text-primary me-1"></i><?php echo get_the_date(); ?></span>
                            <span><i class="fas fa-comment text-primary me-1"></i><?php echo get_comments_number(); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="news-title-large">
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </div>
                </article>
            </div>

            <!-- Правая колонка -->
            <div class="col-lg-6">
                <div class="d-flex flex-column gap-4">

            <?php else : ?>

                <article class="news-card-small d-flex gap-3">
                    <a href="<?php the_permalink(); ?>" class="news-small-img flex-shrink-0">
                        <?php if ($thumb) : ?>
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                    </a>
                    <div class="news-body">
                        <div class="news-meta">
                            <span><i class="fas fa-calendar-alt text-primary me-1"></i><?php echo get_the_date(); ?></span>
                            <span><i class="fas fa-comment text-primary me-1"></i><?php echo get_comments_number(); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="news-title-small">
                            <h5><?php the_title(); ?></h5>
                        </a>
                        <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                    </div>
                </article>

            <?php endif; ?>

            <?php $index++; endwhile; wp_reset_postdata(); ?>

                </div>
            </div>

        </div>
        <?php else : ?>

        <!-- ЗАГЛУШКИ — удалите после появления реальных постов -->
        <div class="row g-4">
            <div class="col-lg-6">
                <article class="news-card-large h-100">
                    <a href="#" class="news-img-wrap d-block">
                        <img src="<?php echo get_template_directory_uri(); ?>/files/img1.jpg" alt="">
                        <span class="news-cat">Конвекторы</span>
                    </a>
                    <div class="news-body">
                        <div class="news-meta">
                            <span><i class="fas fa-calendar-alt text-primary me-1"></i>22 мая 2025 года</span>
                            <span><i class="fas fa-comment text-primary me-1"></i>0</span>
                        </div>
                        <a href="#" class="news-title-large">
                            <h3>Максимальная эффективность внутрипольных конвекторов</h3>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-column gap-4">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                    <article class="news-card-small d-flex gap-3">
                        <a href="#" class="news-small-img flex-shrink-0">
                            <img src="<?php echo get_template_directory_uri(); ?>/files/img1.jpg" alt="">
                        </a>
                        <div class="news-body">
                            <div class="news-meta">
                                <span><i class="fas fa-calendar-alt text-primary me-1"></i>22 мая 2025 года</span>
                                <span><i class="fas fa-comment text-primary me-1"></i><?php echo $i - 1; ?></span>
                            </div>
                            <a href="#" class="news-title-small">
                                <h5>Максимальная эффективность внутрипольных конвекторов</h5>
                            </a>
                            <p class="news-excerpt">From ancient times to the modern era, the fireplace has held a unique place in …</p>
                        </div>
                    </article>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <!-- /ЗАГЛУШКИ -->

        <?php endif; ?>

    </div>
</section>



<section class="cta-banner">
    <div class="cta-overlay"></div>
    <div class="container">
        <div class="cta-inner text-center">
            <h4 class="cta-title mb-4">Как выбрать <span>нужную</span> систему отопления</h4>
            <a href="/faq/" class="btn cta-btn">Читать статью <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>