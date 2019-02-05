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
                <?php the_post_thumbnail('hitmag-grid', array('class'=>'jobs__floatright')); ?>
					 <div class="jobs__details">				  
                         <p class="jobs__details-items"><span>Organisation:</span> <a href="<?php the_field(organisation_web);?>" target="_blank"><?php the_field('organisation'); ?></a></p>
                         <p class="jobs__details-items"><span>Department:</span> <?php the_field('department'); ?></p>
                         <p class="jobs__details-items"><span>Salary:</span> <?php the_field('salary'); ?></p>
                         <p class="jobs__details-items"><span>Job Type:</span> <?php the_field('job_type'); ?></p>
                         <p class="jobs__details-items"><span>NHS Jobs Reference:</span> <?php the_field('job_reference'); ?></p>
                         <p class="jobs__details-items"><span>Closing date:</span> <?php the_field('closing_date'); ?></p>
                         <p class="jobs__details-items"><span>Staff group:</span> <?php the_field('staff_group'); ?></p>
                         <p class="jobs__contact-items"><span>Informal enquiries to:</span> <a href="mailto:<?php the_field(contact_email); echo "?subject="; the_title(); echo "&body=";  ?>"><?php the_field('contact_name'); ?></a> <?php the_field('contact_telelphone');?></p>
              </div>
                     <div class="jobs__description">
                          <?php the_field('job_description'); ?>
                    </div>
                     <div class="jobs__apply-now">
                        <a class="jobs__button" href="<?php the_field(nhs_jobs_url); ?>" target="_blank" title="Visit NHS Jobs website to find out more about this role">Find out more</a>
                     </div>              
    						
			  	

	</main><!-- #main -->

<?php

    endwhile; // End of the loop.

?>
			  <?php
get_sidebar();
get_footer();