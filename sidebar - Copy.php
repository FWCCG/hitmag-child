<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HitMag
 */



$hitmag_sidebar_layout = hitmag_get_layout();

if ( $hitmag_sidebar_layout == 'th-content-centered' || $hitmag_sidebar_layout == 'th-no-sidebar' ) {
	return;
}

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

?>

<aside id="secondary" class="widget-area" role="complementary">
    TEST
	<?php 
	$today = date('Ymd');
	$homepageEvents = new WP_Query(array(
	'posts_per_page' => 3,
	'post_type' => 'event',
	'meta_key' => 'event_date',
	'orderby' => 'meta_value_num',
	'order' => 'ASC',
	'meta_query' => array(
		array(
			'key' => 'event_date',
			'compare' => '>=',
			'value' => $today,
			'type' => 'numeric'
			)
		),
));

while($homepageEvents->have_posts()) {
	$homepageEvents->the_post(); ?>
	<div class="event-summary">
		<a class="event-summary__date t-centre" href="<?php the_permalink(); ?>">
		<span class="event-summary__month"><?php 
			$eventDate = new DateTime(get_field('event_date'));
			echo $eventDate->format('M')
				?></span>
		<span class="event-summary__day"><?php 
			echo $eventDate->format('d')
				?></span>
		</a>
		<div class="event-summary__content">
		<h5 class="event-summary__title" style="margin-bottom: 0px"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		<p><?php echo wp_trim_words(get_the_content(), 18); ?>  <a href="<?php the_permalink(); ?>"><strong>Learn more</strong></a></p></div>
	</div>
	<?php } ?>
	
	
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->