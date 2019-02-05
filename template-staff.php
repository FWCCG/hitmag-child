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
					
			<?php
			  $whoswhoPage = new WP_Query(array(
			  'post_type' => 'staff',
			  'posts_per_page'  => -1,
			  'meta_key' => 'name',  
			  'orderby' => 'meta_value',
			  'order' => 'ASC',
			   ));
			
			  while($whoswhoPage->have_posts()) {
				  $whoswhoPage->the_post(); ?>
			  
				<div class="whoswho__card"><a href="<?php the_permalink(); ?>">
			  		<div class="whoswho__photo">
						<?php the_post_thumbnail('whoswho-small'); ?>
					</div>
					<div class="whoswho__content">		  
					  <h4><?php the_field('salutation'); echo(' '); the_field('first_name'); echo(' '); the_field('name'); ?></h3>
					  <h4><?php the_field('title'); ?></h4>
					  <p><?php the_field('intro'); ?></p>
						
						<?php // vars	
				  		$whichccgs = get_field('ccg');

				  			if( $whichccgs ): ?>
						<ul class="whoswho__ccg-list">
							<?php foreach( $whichccgs as $whichccg ): ?>
							<li class="whoswho__ccg-listitem"><?php echo $whichccg; ?></li>
							<?php endforeach; ?>
						</ul>
							<?php endif; ?>
						
					</div></a>
			  	</div>
			  
				
			  <?php } 
			  
			  ?>
			  </div>  		    
								</section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

        </main>

    <?php

    endwhile; // End of the loop.

?>

<?php 
get_sidebar();
get_footer();