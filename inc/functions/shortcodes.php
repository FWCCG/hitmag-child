<?php

// Create Shortcode govbody
// Shortcode: [govbody ccg="" archive=""]

function create_govbody_shortcode($atts) {

	$atts = shortcode_atts(
		array(
			'ccg' => '',
			'archive' => '',
		),
		$atts,
		'govbody'
	);

	$ccg = $atts['ccg'];
	$archive = $atts['archive'];
    $today = date('Ymd');
    
    if ($archive=='true'){
                    $orderBy = "DESC";
                } else {
                    $orderBy = "ASC";
                } ;
    if ($archive=="true"){
                    $futurepast = '<';
                } else {
                    $futurepast = '>='; 
                } ;
    
    $govbodyShortcode = new WP_Query(array(
			  'post_type' => 'event',
			  'posts_per_page'  => -1,
			  'meta_key' => 'start',
              'meta_query' => array(
                array(
                     'key'     => 'start',
                     'value'   => $today,
                     'compare' => $futurepast,
                     'type'    => 'DATETIME',
                )),
              'orderby' => "meta_value",
			  'order' => $orderBy,
              'tax_query' => array(
                  array(
                      'taxonomy' => 'eventcategory',
                      'field' => 'slug',
                      'terms' => $ccg,
                      )
                  )
            ));
  
    
    if($govbodyShortcode->have_posts()) : while($govbodyShortcode->have_posts()) : $govbodyShortcode->the_post(); 
    
        $GBlink = get_the_permalink();
        $GBtempDate = get_field(start, false, false);
        $GBnewDate = date("F Y", strtotime($GBtempDate));
        $GBoutput .= "<li><a href='$GBlink'>$GBnewDate</a></li>";
    
                        
     endwhile; else: $GBoutput .="nothing found.";
    
    endif;
    
    wp_reset_query(); 
    
    return '<div class="govbody__container">' . $GBoutput . '</div>';

}
add_shortcode( 'govbody', 'create_govbody_shortcode' );

// Create shortcode You said, We Dids

// Add Shortcode

function yswd_shortcode() {

    $yswdShortcode = new WP_Query(array(
			  'post_type' => 'yswd',
			  'posts_per_page'  => 10,
              'paged' => $paged,  
			  'orderby' => 'date',
			   ));
    
   if($yswdShortcode->have_posts()) : while($yswdShortcode->have_posts()) : $yswdShortcode->the_post(); 
    
        $yswdLink .= get_the_permalink();
        $yswdYouSaid = get_field('you_said');
        $yswdWeDid = mb_strimwidth(get_field('we_did'), 0, 100, '...');
        $yswdOutput .= "<div class='yswd__container'><div class='yswd__yousaid'>$yswdYouSaid</div><div class='yswd__wedid'>$yswdWeDid<br><a href='$yswdLink'>Read More</a></div></div>";
    
    
    endwhile; else: $yswdOutput .="nothing found.";
        
    endif;
    
    wp_reset_query();     
    
    return $yswdOutput;
 
}
add_shortcode( 'yswd', 'yswd_shortcode' );

// Create shortcode upcoming events

// Add Shortcode

function upcomingEvents_shortcode() {
  
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
    
    return $upcomingEventsOutput . '<span class="events_shortcode__allevents"><a class="btn btn--blue" href="https://www.fyldecoastccgs.nhs.uk/news/upcoming-events/">View all  upcoming events</a></span>'; 
}    
    add_shortcode( 'upcoming-events', 'upcomingEvents_shortcode' );

// Create shortcode footer upcoming events

// Add Shortcode

function footerEvents_shortcode() {

    $today = date('Ymd');
    
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
        $upcomingEventsDate = get_field(start, false, false);
        $upcomingEventsNewDate = date("d F Y", strtotime($upcomingEventsDate));
        $upcomingEventsNewTime = date("g:i a", strtotime($upcomingEventsDate));
        $upcomingEventsOutput .= "<li class='jobs_shortcode__item'><a href='$upcomingEventsLink'><span class='jobs_shortcode__title'>$upcomingEventsTitle</span><br><span class='jobs_shortcode__meta'>$upcomingEventsNewDate at $upcomingEventsNewTime</span><br><span class='jobs_shortcode__meta'>$upcomingEventsCategoryTop</span></a></li>   
        ";
    
    
    endwhile; else: $upcomingEventsOutput .="nothing found.";
        
    endif;
    
    wp_reset_query();     
    
    return '<ul class="jobs_shortcode">' . $upcomingEventsOutput . '<span class="events_shortcode__allevents"><a class="btn btn--white" href="https://www.fyldecoastccgs.nhs.uk/news/upcoming-events/">View all events</a></span>';
 
}
add_shortcode( 'footer-events', 'footerEvents_shortcode' );


// Create shortcode widget jobs

// Add Shortcode

function jobs_shortcode() {

    $today = date('Ymd');
    
     $jobsShortcut = new WP_Query(array(
			  'post_type' => 'job',
			  'posts_per_page'  => 5,
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
        $jobsOrganisations = get_field(organisation);
        $jobsSalary = get_field(salary);
        $jobsDate = get_field(closing_date, false, false);
        $jobsClose = date("d F Y", strtotime($jobsDate));
        $jobsOutput .= "<li class='jobs_shortcode__item'><a href='$jobsLink'><span class='jobs_shortcode__title'>$jobsTitle</span>
        <br><span class='jobs_shortcode__meta'>Salary: $jobsSalary</span>
        <br><span class='jobs_shortcode__meta'>Organisation: $jobsOrganisations</span>
        <br><span class='jobs_shortcode__meta'>Closing date: $jobsClose</span>
        </a></li>";
    
    
    endwhile; else: $jobsOutput .="nothing found.";
        
    endif;
    
    wp_reset_query();     
    
    return '<ul class="jobs_shortcode">' . $jobsOutput . '</ul> <span class="jobs_shortcode__alljobs"><a class="btn btn--white" href="https://www.fyldecoastccgs.nhs.uk/job/">View all jobs</a></span>';
 
}
add_shortcode( 'jobs', 'jobs_shortcode' );

?>