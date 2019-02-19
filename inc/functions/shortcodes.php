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
        $GBtempDate = get_field('start', false, false);
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

?>