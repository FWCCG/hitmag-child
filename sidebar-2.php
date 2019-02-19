<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HitMag
 */

?>

<aside id="secondary" class="widget-area" role="complementary">
<div class="widget">
<h4 class="widget-title">Upcoming events</h4>
<?php 
    $today = date('Ymd');
  $terms = get_field('eventcategory');
  $upcomingeventsshortcode = new WP_Query(array(
            'post_type' => 'event',
            'posts_per_page'  => 3,
            'meta_key' => 'start',
            'meta_query' => array(
              array(
                   'key'     => 'start',
                   'value'   => $today,
                   'compare' => '>=',
                   'type'    => 'DATETIME',
              )),
            'orderby' => 'meta_value',
            'order' => 'ASC'
             ));
   if($upcomingeventsshortcode->have_posts()) : while($upcomingeventsshortcode->have_posts()) : $upcomingeventsshortcode->the_post(); 
      $upcomingEventsCat = get_field('event_category');
      $upcomingEventsCatID = $upcomingEventsCat[0];
      $upcomingEventsLink .= get_the_permalink();
      $upcomingEventsTitle = get_the_title();
      $upcomingEventsDate = get_field('start', false, false);
      $upcomingEventsDay = date("j", strtotime($upcomingEventsDate));
      $upcomingEventsMonth = date("M", strtotime($upcomingEventsDate));
      $upcomingEventsOutput .= "
      
      <div class='event-summary'> 

          <a class='event-summary__date t-center event-cat-$upcomingEventsCatID' href='$upcomingEventsLink'>
              <span class='event-summary__month'>$upcomingEventsMonth</span>
              <span class='event-summary__day'>$upcomingEventsDay</span>  
            </a>
          <div class='event-summary__content'>
              <span class='event-summary__title headline headline--tiny'><a href='$upcomingEventsLink'>$upcomingEventsTitle</a></span>
              </div>
      </div>";
  
  
  endwhile; else: $upcomingEventsOutput .="nothing found.";
      
  endif;
  wp_reset_query();     
  
  echo $upcomingEventsOutput . '<span class="events_shortcode__allevents"><a class="btn btn--blue" href="https://www.fyldecoastccgs.nhs.uk/news/upcoming-events/">View all  upcoming events</a></span>'; 
   ?>
</div>
<?php dynamic_sidebar( 'sidebar-2' ); ?>
	
</aside><!-- #secondary -->