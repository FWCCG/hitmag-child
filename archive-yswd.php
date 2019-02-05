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
			<span class="entry-title-container"><h1 class="page-title entry-title">All you said, we dids</h1></span>
			</header>
            
            
            <!-- .page-header -->
		<?php 
            
             $today = date('Ymd');
             $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
             $yswdPage = new WP_Query(array(
			  'post_type' => 'yswd',
			  'posts_per_page'  => 10,
              'paged' => $paged,  
			  'orderby' => 'date',
			   ));
                        
            if ( $yswdPage->have_posts() ) : while ( $yswdPage->have_posts() ) : $yswdPage->the_post(); ?>
				
            <div class="yswd__container">
                <div class="yswd__yousaid"><?php the_field(you_said); ?></div>
                <div class="yswd__wedid"><?php echo mb_strimwidth(get_field(we_did), 0, 100, '...'); ?> <br><a href="<?php the_permalink(); ?>">Read More</a></div>
            </div>
            
			<?php endwhile; else: ?>
			
			<p>Sorry, no posts to list</p>

			<?php endif; ?>
			

		</article>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();