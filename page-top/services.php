<section class="features-section py-5">
    <div class="container">
        <div class="row g-0">

            <?php
            $features = [
                [
                    'icon'  => 'fas fa-building',
                    'title' => 'Жилые комплексы',
                    'desc'  => 'Комплексные инженерные решения для объектов премиум-класса. Обеспечиваем безупречный микроклимат и эстетику в каждом квадратном метре, соблюдая строгие стандарты застройщиков.',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-home',
                    'title' => 'Частные дома',
                    'desc'  => 'Создаем персональные системы тепла, объединяя инновационные технологии и уют. Индивидуальный подбор оборудования под архитектурные особенности вашего дома.',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-door-open',
                    'title' => 'Квартиры',
                    'desc'  => 'Элегантные решения для городских интерьеров. Помогаем освободить пространство и интегрировать современные системы отопления без ущерба для вашего дизайна.',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-store',
                    'title' => 'Коммерческие помещения',
                    'desc'  => 'Высокопроизводительное оборудование для бизнеса. Сочетаем надёжность систем с архитектурной чистотой пространства для комфорта ваших гостей и сотрудников.',
                    'link'  => '#',
                ],
            ];

            $last = count($features) - 1;
            foreach ($features as $i => $f) :
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="feature-item text-center <?php echo $i < $last ? 'feature-divider' : ''; ?>">
                    <div class="feature-icon mb-4">
                        <i class="<?php echo esc_attr($f['icon']); ?>"></i>
                    </div>
                    <h5 class="feature-title"><?php echo esc_html($f['title']); ?></h5>
                    <p class="feature-desc"><?php echo esc_html($f['desc']); ?></p>
                    <a href="<?php echo esc_url($f['link']); ?>" class="feature-link">
                        Подробнее <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<style>

</style>