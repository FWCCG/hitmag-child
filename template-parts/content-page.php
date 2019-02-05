<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('hitmag-page'); ?>>
	<header class="entry-header">
		<?php the_title( '<span class="entry-title-container"><h1 class="entry-title">', '</h1></span>' ); ?>
	</header><!-- .entry-header -->
	<?php if (!get_field('no_featured_image') == 1) { ?>
    <?php if (has_post_thumbnail()) { ?>
       <div class="accredit_autor_container"><?php the_post_thumbnail( 'hitmag-landscape' ); ?>
        
   <?php  //Accredit Autor IF statement meta box for copyrited images//  
    if (get_field('accredit_author') ): ?>
    <div class="accredit_autor_box"><p class="accredit_autor-box__text"><?php the_field('accredit_author');?></p></div></div>
        <?php endif; 
    //Accredit Autor meta box for copyrited images ENDS
    ?>

    <?php } else { ?>
        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/default-page-image.jpg" alt="<?php the_title(); ?>" />
        <?php }  ?>
    <?php } ?>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hitmag' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'hitmag' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
	<div class="last-updated-container"><?php echo wpb_last_updated_date($content);?></div>
</article><!-- #post-## -->