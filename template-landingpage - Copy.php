<?php
/**
 * Template Name: Landing page v2
 *
 * Use this template to display all subpages under this page.
 * 
 * @package HitMag
 */

get_header(); 

    while ( have_posts() ) : the_post(); ?>

        <main id="main" class="site-main subpage_page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							    <section class="subpage_container" itemprop="articleBody">

                                                                      
                             <?php $promoPage = new WP_Query( array(
                                'post_parent' => $post->ID,
                                'showposts' => 6,
                                'post_type' => 'page',
				                'orderby' => 'title',
				                'order' => ASC,
                                'meta_query' => array(
                                array(
                                    'key' => 'promo',
                                    'value' => '1')
                                )
				                )); ?>

				<?php if ( $promoPage->have_posts() ) : while ( $promoPage->have_posts() ) : $promoPage->the_post(); ?>
				
				<div class="whoswho__card practice__card">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('hitmag-featured', array('class'=>'whoswho__floatleft')) ?>
						<strong><?php the_title() ?>
				</div>
			
					
			<?php endwhile; else: ?>
			</ul>	
			
              <p>Sorry, no posts to list</p>

			<?php endif; ?>

                                    
                                    
								    
								</section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

        </main>

    <?php

    endwhile; // End of the loop.

?>

<?php 
get_sidebar();
get_footer();