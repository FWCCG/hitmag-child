<?php
/**
 * Template Name: Who's who page
 *
 * Use this template to display all staff memebrs on the who's who page.
 * 
 * @package HitMag
 */

get_header(); 

    while ( have_posts() ) : the_post(); ?>
		
        <main id="main" class="site-main whoswho_page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			  
			  <header class="entry-header">
		<?php

			hitmag_category_list();

		the_title( '<span class="entry-title-container"><h1 class="entry-title">', '</h1></span>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		
		<?php ; endif ?>

	</header><!-- .entry-header -->
			
			 <?php the_content();?> 

			<div class="whoswho__container">
			
<ul>
<?php  

$args = array(
    'orderby'       => 'name', 
    'order'         => 'ASC', 
    'number'        => null,
    'optioncount'   => false, 
    'exclude_admin' => false, 
    'show_fullname' => true,
    'hide_empty'    => false,
    'echo'          => true,
    'style'         => 'list',
    'html'          => true,
);
	wp_list_authors( $args ) ?>
</ul>




								</section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

        </main>

    <?php

    endwhile; // End of the loop.

?>

<?php 
get_sidebar();
get_footer();