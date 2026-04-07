<?php get_header(); 

include(locate_template('template-parts/menu.php')); 
include(locate_template('template-parts/phead.php'));

 ?>
 

<section id="page" class="py-3 pt-3 mt-3">
    <div class="container">
        <h2 class="section-title"><?php the_title(); ?></h2>
        
        <div class="row g-4">
				<?php the_content(); ?>
        </div>
    </div>
</section>
 
<?php include(locate_template('page-top/ctasec.php'));

get_footer(); 