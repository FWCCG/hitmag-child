<?php
/**
 * The template for displaying the campaigns page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package HitMag
 */

get_header(); ?>

        <main id="main" class="site-main whoswho_page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			  
			  <header class="entry-header">
				<?php

					hitmag_category_list();

					the_title( '<span class="entry-title-container"><h1 class="entry-title">', '</h1></span>' ); ?>


			</header><!-- .entry-header -->
              <div class="campaigns__container">
    <?php     query_posts('cat=7');
              
              if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
              
                  <div class="campaigns__item"><a href="<?php the_permalink();?>"><?php if (has_post_thumbnail()) { 
                            the_post_thumbnail('whoswho-small', array('class'=>'campaigns__photo')); } else { ?>
                            <img class="campaigns__photo" src="<?php bloginfo('stylesheet_directory'); ?>/images/default-event-image.jpg" alt="<?php the_title(); ?>" /><?php } ?><p class="campaigns__title"><?php the_title();?></p></a></div>
              
        <?php endwhile; // End of the loop.
              
            endif; ?>        
			  	</div>
	</main><!-- #main -->


			  <?php
get_sidebar();
get_footer();