<section class="features-section py-5">
    <div class="container">
        <div class="row g-0">

            <?php
            $features = [
                [
                    'icon'  => 'fas fa-building',
                    'title' => 'Жилые комплексы',
                    'desc'  => 'Равным образом реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-home',
                    'title' => 'Частные дома',
                    'desc'  => 'Равным образом реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-door-open',
                    'title' => 'Квартиры',
                    'desc'  => 'Равным образом реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации',
                    'link'  => '#',
                ],
                [
                    'icon'  => 'fas fa-store',
                    'title' => 'Коммерческие помещения',
                    'desc'  => 'Равным образом реализация намеченных плановых заданий обеспечивает широкому кругу (специалистов) участие в формировании соответствующий условий активизации',
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