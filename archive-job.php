<?php
/**
 * The template for displaying archive events
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			<header class="entry-header page-header">
			<span class="entry-title-container"><h1 class="page-title entry-title">All jobs</h1></span>
			</header><!-- .page-header -->

		<?php 
            
             $today = date('Ymd');
             $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
             $jobsPage = new WP_Query(array(
			  'post_type' => 'job',
			  'posts_per_page'  => 10,
			  'meta_key' => 'closing_date',
              'paged' => $paged,  
              'meta_query' => array(
	               array(
                        'key'     => 'closing_date',
                        'value'   => $today,
                        'compare' => '>=',
                        'type'    => 'DATETIME',
	                       ),
                    ),
			  'orderby' => 'date',
			   ));
                        
            if ( $jobsPage->have_posts() ) : while ( $jobsPage->have_posts() ) : $jobsPage->the_post(); ?>
				
            <a href="<?php the_permalink();?>"><div class="jobs-archive__container">
                <div class="jobs-archive__container-image"><?php the_post_thumbnail('hitmag-thumbnail');?></div>
                <div class="jobs-archive__job-details">
                    <h4><?php the_title();?></h4>
                    <p>Organisation: <?php the_field('organisation'); ?></p>
                    <p>Salary: <?php the_field('salary'); ?></p>
                    <p>Job type: <?php the_field('job_type'); ?></p>
                    <p>Closing date: <?php the_field('closing_date'); ?></p>
                </div>
			</div></a>
            
			<?php endwhile; else: ?>
			
			<p>Sorry, no posts to list</p>

			<?php endif; ?>
			

		</article>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();