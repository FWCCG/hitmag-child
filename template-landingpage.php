<?php
/**
 * Template Name: Landing page
 *
 * Use this template to display all subpages under this page.
 * 
 * @package HitMag
 */

get_header(); 

    while ( have_posts() ) : the_post(); ?>

        <main id="main" class="site-main subpage_page hitmag-page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
          <header class="entry-header landing-page">
		<?php the_title( '<h1 class="entry-title landing-page">', '</h1>' ); ?>


	</header><!-- .entry-header -->        
                        <?php the_content();?>
							    <section class="promo-boxes_container" itemprop="articleBody">

                                                
                                <?php $promoPage = new WP_Query( array(
                                'post_parent' => $post->ID,
                                'showposts' => 6,
                                'post_type' => 'page',
				                'orderby' => 'menu_order',
				                'order' => 'ASC',
                                'meta_query' => array(
                                array(
                                    'key' => 'promo',
                                    'value' => '1')
                                )
				                )); ?>

				<?php if ( $promoPage->have_posts() ) : while ( $promoPage->have_posts() ) : $promoPage->the_post(); ?>
				
				<div class="promo-boxes">
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) { 
                            the_post_thumbnail('hitmag-featured'); 
                        } else { ?>
                        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/default-promo-image.jpg" alt="<?php the_title(); ?>" />
                        <?php } ?>
                        <span class="promo-boxes-title"><?php the_title() ?></span></a>
				</div>
			
					
			<?php endwhile; else: ?>
			</ul>	
			
              <p>Sorry, no promo pages to list</p>

			<?php endif; wp_reset_query() ?>
              
              </section>
						<hr>		
                             <?php $noPromoPage = new WP_Query( array(
                                'post_parent' => $post->ID,
                                'posts_per_page' => -1,
                                'post_type' => 'page',
				                'orderby' => 'title',
				                'order' => 'ASC',
                                'meta_query' => array(
                                array(
                                    'key' => 'promo',
                                    'value' => '0',)
                                )
				                )); ?>
            
                <section class="promo-boxes_container" itemprop="articleBody">
				<?php if ( $noPromoPage->have_posts() ) : while ( $noPromoPage->have_posts() ) : $noPromoPage->the_post(); ?>
				
				<a class="no-promo-boxes__item" href="<?php the_permalink()?>"><div class="no-promo-boxes">
                    <i class="fas fa-arrow-circle-right"></i> <?php the_title() ?>
				</div></a>
			
					
			<?php endwhile; else: ?>
			</ul>	
			
              <p>Sorry, no promo pages to list</p>

			<?php endif; wp_reset_query() ?>
								
            </section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

        </main>

    <?php

    endwhile; // End of the loop.

?>

<?php 
get_sidebar();
get_footer();