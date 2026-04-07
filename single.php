<?php get_header(); 

include(locate_template('template-parts/menu.php')); ?>
 

<section id="page" class="py-5 pt-5 mt-5">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>
        
        <div class="row g-4">
				<?php the_content(); ?>
        </div>
    </div>
</section>
 
<?php include(locate_template('page-top/ctasec.php'));

get_footer(); 