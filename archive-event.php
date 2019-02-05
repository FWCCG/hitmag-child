<?php
/**
 * The template for displaying archive events
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

get_header(); 

   ?>


<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		 <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			  
			  <header class="entry-header page-header">
			<span class="entry-title-container"><h1 class="page-title entry-title">All events</h1></span><!-- .entry-header -->
			
			 <?php the_content();?> 
			  
			<div class="whoswho__container">
				
			<?php
              $today = date('Ymd');
              $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
              $eventsPage = new WP_Query(array(
			  'post_type' => 'event',
			  'posts_per_page'  => 10,
			  'meta_key' => 'start',
              'paged' => $paged,  
			  'orderby' => 'meta_value',
			  'order' => $orderBy,
            ));
			  while ($eventsPage->have_posts()) { $eventsPage->the_post(); 
                
                  $EventStart = get_field('start', false, false);
                  $EventDate = date("d F Y", strtotime($EventStart));
                  $EventTime = date("g:i a", strtotime($EventStart));
                ?>
			  	
                <div class="events__item"><a href="<?php the_permalink(); ?>">
			  		<div class="events__photo">
						<?php if (has_post_thumbnail()) { 
                            the_post_thumbnail('whoswho-small'); } else { ?>
                            <img class="events__photo" src="<?php bloginfo('stylesheet_directory'); ?>/images/default-event-image.jpg" alt="<?php the_title(); ?>" />
                        <?php } ?>
                    </div>
                            <span class="events__title"><?php echo mb_strimwidth( get_the_title(), 0, 50, '...' );  ?></span></a></br>
                            <span class="events__meta"><i class="far fa-calendar-alt"><span class="screen-reader-text">Date</span></i> <?php echo $EventDate ?></span>
                            <span class="events__meta"><i class="far fa-clock"><span class="screen-reader-text">Time</span></i> <?php echo $EventTime ?></span>
                            
					 </div>
			 
			  <?php }  
                
              if (function_exists(custom_pagination)) { ?>
    <div class="custom-pagination">
        <?php custom_pagination($eventsPage->max_num_pages, "", $paged); ?>
    </div>
			  <?php } ?>
			  </div>  
             
								</section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();