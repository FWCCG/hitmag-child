<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package HitMag
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php 	$mypages = get_pages( 
            array( 
                'child_of' => $post->ID, 
                'sort_column' => 'post_date', 
                'sort_order' => 'desc' ) ); 
            
            foreach( $mypages as $page ) {	
                $content = $page->post_content; 
                if ( ! $content ) // Check for empty page 			continue;  		$content = apply_filters( 'the_content', $content ); 	?>
            
                <h2><a href="<?php echo get_page_link( $page->ID ); ?>"><?php echo $page->post_title; ?></a></h2>
                <div class="entry"><?php echo $content; ?></div>
<?php 	}	 ?>

	</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();	