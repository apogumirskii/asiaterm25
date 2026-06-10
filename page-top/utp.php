<section class="about-section py-5">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <h6 class="about-subheading">Азия Терм</h6>
                <h2 class="about-heading mb-4">Мы поставляем оборудование для отопления и охлаждения от Европейских производителей<br>Проекты любого размера</h2>

                <ul class="about-list list-unstyled mb-4">
                    <li>
                        <span class="about-num">01.</span>
                        <div>
                            <h5 class="about-item-title">Широкий ассортимент</h5>
                            <p class="about-item-desc">От внутрипольных конвекторов до дизайнерских радиаторов и высокотехнологичных тепловых насосов. Мы собрали в одном каталоге всё необходимое для создания современной системы отопления и охлаждения.</p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">02.</span>
                        <div>
                            <h5 class="about-item-title">Гарантия качества</h5>
                            <p class="about-item-desc">Прямые поставки от ведущих европейских заводов обеспечивают надёжность оборудования на десятилетия. Вся продукция сертифицирована и адаптирована к эксплуатации в сложных климатических условиях.</p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">03.</span>
                        <div>
                            <h5 class="about-item-title">Индивидуальный расчёт</h5>
                            <p class="about-item-desc">Подбираем оборудование на основе точных теплотехнических расчётов вашего объекта. Учитываем архитектурные особенности, площадь остекления и ваши личные пожелания к дизайну и бюджету.</p>
                        </div>
                    </li>
                    <li>
                        <span class="about-num">04.</span>
                        <div>
                            <h5 class="about-item-title">Комплексные решения</h5>
                            <p class="about-item-desc">Мы не просто поставляем оборудование, а предлагаем готовую экосистему: от интеллектуальных систем управления до профессионального шеф-монтажа и ввода в эксплуатацию.</p>
                        </div>
                    </li>
                </ul>

                <a href="<?php echo esc_url(asiaterm_url('catalog')); ?>" class="btn about-btn">В каталог <i class="fas fa-arrow-right ms-2"></i></a>
            </div>

            <div class="col-lg-6 text-center">
                <?php
                /**
                 * Источник изображений для UTP (приоритет):
                 *   1) front_utp_gallery (Meta Box на TopPage) — карусель если 2+ фото
                 *   2) Customizer asiaterm_utp_image — одна картинка
                 *   3) /files/topimg2.png — fallback
                 */
                $front_page_id = (int) get_option('page_on_front');
                $utp_gallery   = $front_page_id
                    ? rwmb_meta('front_utp_gallery', ['object_type' => 'post'], $front_page_id)
                    : [];
                $utp_gallery   = is_array($utp_gallery) ? array_values($utp_gallery) : [];
                $utp_count     = count($utp_gallery);
                ?>

                <?php if ($utp_count > 1) : ?>
                    <div class="swiper swiper-utp-gallery">
                        <div class="swiper-wrapper">
                            <?php foreach ($utp_gallery as $img) : ?>
                                <div class="swiper-slide about-gallery-slide">
                                    <?php echo asiaterm_picture_tag(
                                        (int) $img['ID'],
                                        'about-gallery',
                                        'about-gallery-mob',
                                        [
                                            'alt'   => $img['alt'] ?? '',
                                            'class' => 'about-gallery-img',
                                        ]
                                    ); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination about-gallery-pagination"></div>
                    </div>
                <?php elseif ($utp_count === 1) : ?>
                    <?php $img = $utp_gallery[0]; ?>
                    <?php echo asiaterm_picture_tag(
                        (int) $img['ID'],
                        'about-gallery',
                        'about-gallery-mob',
                        ['alt' => $img['alt'] ?? 'Asiaterm', 'class' => 'company-img-wrap']
                    ); ?>
                <?php else : ?>
                    <?php
                    $utp_id  = asiaterm_brand_image_id('utp');
                    $utp_url = asiaterm_brand_image('utp', 'files/topimg2.png');
                    echo asiaterm_picture_tag(
                        $utp_id ?: $utp_url,
                        'about-gallery',
                        'about-gallery-mob',
                        ['alt' => 'Asiaterm', 'class' => 'company-img-wrap']
                    );
                    ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<style>

</style> 