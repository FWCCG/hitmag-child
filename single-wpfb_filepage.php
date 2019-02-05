<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
                       
			 <?php the_content(); ?>

	</main><!-- #main -->
            </article>
<?php

    endwhile; // End of the loop.

?>
			  <?php
get_sidebar();
get_footer();