<?php /* Template Name: TopPage  */   get_header();

include(locate_template('template-parts/menu.php'));


echo '<div class="lte-text-page  disabled"><div class="row centered"><div class="col-xl-12 col-xs-12"><article id="post-32647" class="post-32647 page type-page status-publish hentry">	<div class="entry-content clearfix" id="entry-div"><div data-elementor-type="wp-page" data-elementor-id="32647" class="elementor elementor-32647">';
				
include(locate_template('page-top/slider.php'));

include(locate_template('page-top/about.php'));

include(locate_template('page-top/cattop.php'));



include(locate_template('page-top/portfolio.php'));

include(locate_template('page-top/services.php')); //направления

include(locate_template('page-top/utp.php'));

include(locate_template('page-top/popular.php'));

include(locate_template('page-top/sertificat.php'));

include(locate_template('page-top/news.php'));

include(locate_template('page-top/partners.php'));

echo '</div></div></article></div></div></div></div>';



include(locate_template('page-top/ctasec.php'));

get_footer();
