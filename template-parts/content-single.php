<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('hitmag-single'); ?>>
	<header class="entry-header">
		<?php

			hitmag_category_list();

			the_title( '<h1 class="entry-title">', '</h1>' );

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php hitmag_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	</header><!-- .entry-header -->
	
	<?php if (has_post_thumbnail()) { ?>
    
       <div class="accredit_autor_container"> <?php the_post_thumbnail( 'hitmag-landscape' ); ?>
        
    <?php  //Accredit Autor IF statement meta box for copyrited images//  
    if (get_field('accredit_author') ): ?>
    <div class="accredit_autor_box"><p class="accredit_autor-box__text"><?php the_field('accredit_author');?></p></div>
        <?php endif; 
    //Accredit Autor meta box for copyrited images ENDS
    ?>
    </div>
    
<?php } else { ?> 
        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/default-news-image.jpg" alt="<?php the_title(); ?>" />
        <?php } ?>

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'hitmag' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hitmag' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php 
			hitmag_entry_footer(); 
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
