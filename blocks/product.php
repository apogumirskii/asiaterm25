<div class="swiper-slide">
<div class="product-card">
	<div class="product-card-img">
		<a href="<?php echo esc_url(get_permalink($id)); ?>">
			<?php if ($thumb) : ?>
				<img src="<?php echo esc_url($thumb); ?>" loading="lazy" alt="<?php echo esc_attr(get_the_title($id)); ?>">
			<?php else : ?>
				<img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.jpg" alt="">
			<?php endif; ?>
		</a>
	</div>
	<div class="product-card-body text-center">
		<a href="<?php echo esc_url(get_permalink()); ?>" class="product-card-title">
			<h5><?php the_title(); ?></h5>
		</a>
		<?php if ($excerpt) : ?>
			<p class="product-card-desc"><?php echo esc_html($excerpt); ?></p>
		<?php endif; ?>
		<div class="product-card-price">
			<?php // echo $price ? esc_html($price) : 'По запросу'; ?>
		</div>
		<?php if ($var_titles) : ?>
			<div class="product-card-vars mb-3">
				<?php foreach ($var_titles as $var) : ?>
					<span class="typesvar"><?php echo esc_html($var); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<a href="<?php echo esc_url(get_permalink($id)); ?>" class="btn product-card-btn">
			Подробнее <i class="fas fa-arrow-right ms-1"></i>
		</a>
	</div>
</div>
</div>