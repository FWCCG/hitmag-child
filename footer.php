<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HitMag
 */

?>
	</div><!-- .hm-container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="hm-container">
			<div class="footer-widget-area">
				<div class="footer-sidebar" role="complementary">
			
			<div class="widget">
			<h4 class="widget-title">Upcoming events</h4>
			<?php	$today = date('Ymd');
    
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
        $upcomingEventsID = get_the_ID();
        $upcomingEventsCategory = get_the_terms($post->ID, 'eventcategory');
        $upcomingEventsCategoryTop = $upcomingEventsCategory[0]->name;
        $upcomingEventsLink .= get_the_permalink();
        $upcomingEventsTitle = get_the_title();
        $upcomingEventsDate = get_field('start', false, false);
        $upcomingEventsNewDate = date("d F Y", strtotime($upcomingEventsDate));
        $upcomingEventsNewTime = date("g:i a", strtotime($upcomingEventsDate));
        $upcomingEventsOutput .= "<li class='jobs_shortcode__item'><a href='$upcomingEventsLink'><span class='jobs_shortcode__title'>$upcomingEventsTitle</span><br><span class='jobs_shortcode__meta'>$upcomingEventsNewDate at $upcomingEventsNewTime</span><br><span class='jobs_shortcode__meta'>$upcomingEventsCategoryTop</span></a></li>   
        ";
    
    
    endwhile; else: $upcomingEventsOutput .="nothing found.";
        
    endif;
    
    wp_reset_query();     
    
    echo '<ul class="jobs_shortcode">' . $upcomingEventsOutput . '<span class="events_shortcode__allevents"><a class="btn btn--white" href="https://www.fyldecoastccgs.nhs.uk/news/upcoming-events/">View all events</a></span>';
		?>	</div>	
				<?php if ( ! dynamic_sidebar( 'footer-left' ) ) : ?>
						
					<?php endif; // end sidebar widget area ?>
				</div><!-- .footer-sidebar -->
		
				<div class="footer-sidebar" role="complementary">

				<div class="widget"><h4 class="widget-title">Latest jobs</h4>
				<?php
				$today = date('Ymd');
    
		$jobsShortcut = new WP_Query(array(
			 'post_type' => 'job',
			 'posts_per_page'  => 3,
			 'meta_key' => 'closing_date',
						 'paged' => $paged,  
						 'meta_query' => array(
								array(
											 'key'     => 'closing_date',
											 'value'   => $today,
											 'compare' => '>=',
											 'type'    => 'DATETIME',
												),
									 ),
			 'orderby' => 'date',
				));
											 
					 if ( $jobsShortcut->have_posts() ) : while ( $jobsShortcut->have_posts() ) : $jobsShortcut->the_post();
	 
			 $jobsLink .= get_the_permalink();
			 $jobsTitle = get_the_title();
			 $jobsOrganisations = get_field('organisation');
			 $jobsSalary = get_field('salary');
			 $jobsDate = get_field('closing_date', false, false);
			 $jobsClose = date("d F Y", strtotime($jobsDate));
			 $jobsOutput .= "<li class='jobs_shortcode__item'><a href='$jobsLink'><span class='jobs_shortcode__title'>$jobsTitle</span>
			 <br><span class='jobs_shortcode__meta'>Salary: $jobsSalary</span>
			 <br><span class='jobs_shortcode__meta'>Organisation: $jobsOrganisations</span>
			 <br><span class='jobs_shortcode__meta'>Closing date: $jobsClose</span>
			 </a></li>";
	 
	 
	 endwhile; else: $jobsOutput .="nothing found.";
			 
	 endif;
	 
	 wp_reset_query();     
	 
	 echo '<ul class="jobs_shortcode">' . $jobsOutput . '</ul> <span class="jobs_shortcode__alljobs"><a class="btn btn--white" href="https://www.fyldecoastccgs.nhs.uk/job/">View all jobs</a></span>';
				?>
				</div>
					<?php if ( ! dynamic_sidebar( 'footer-mid' ) ) : ?>

					<?php endif; // end sidebar widget area ?>
				</div><!-- .footer-sidebar -->		

				<div class="footer-sidebar" role="complementary">
					<?php if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>

					<?php endif; // end sidebar widget area ?>
				</div><!-- .footer-sidebar -->			
			</div><!-- .footer-widget-area -->
		</div><!-- .hm-container -->

		<div class="site-info">
			<div class="hm-container">
				<div class="site-info-owner">
					Copyright &copy; NHS Blackpool and NHS Fylde and Wyre CCGs <?php echo date('Y'); ?>
				</div>			
				<div class="site-info-designer">
					<?php
						printf( esc_html__( 'Powered by %1$s and %2$s.', 'hitmag' ),
							'<a href="https://wordpress.org" target="_blank" title="WordPress">WordPress</a>',
							'<a href="https://themezhut.com/themes/hitmag/" target="_blank" title="HitMag WordPress Theme">HitMag</a>'
						); 
					?>
				</div>
			</div><!-- .hm-container -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<div class="search-overlay">
    <div class="search-overlay__top">
      <div class="container">
        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>
    
    <div class="container">
      <div id="search-overlay__results"></div>
    </div>

  </div>


<?php wp_footer(); ?>
</body>
</html>