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

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}

?>
TEST
<aside id="secondary" class="widget-area" role="complementary">
		<h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

        <?php 
          $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'start',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'start',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )
            )
          ));

          while($homepageEvents->have_posts()) {
            $homepageEvents->the_post(); ?>
            <div class="event-summary">
              <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month"><?php
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('M')
                ?></span>
                <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>  
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php if (has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
              </div>
            </div>
          <?php }
        ?>
        
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->