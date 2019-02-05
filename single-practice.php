<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package HitMag
 */

get_header(); ?>

<script type="text/javascript">
(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

});

})(jQuery);
</script>

<?php

while ( have_posts() ) : the_post(); ?>
		<div id="primary" class="content-area">
        <main id="main" class="site-main practice_page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			  
			  <header class="entry-header">
				<?php

					hitmag_category_list();

					the_title( '<span class="entry-title-container"><h1 class="entry-title">', '</h1></span>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
		
				<?php ; endif ?>

			</header><!-- .entry-header -->

						<?php if (has_post_thumbnail()) 
                  
                            { the_post_thumbnail('whoswho-large', array('class'=>'whoswho__floatleft')); }
                  
                        else { ?>
                            
                        <img class="whoswho__floatleft" src="<?php bloginfo('stylesheet_directory'); ?>/images/default-practice-image.jpg" alt="<?php the_title(); ?>" />
                        
                        <?php } ?>
					
					    <h4 class="whoswho__single-title"><?php the_field('title'); ?></h4>
			  			<h6 class="whoswho__single"><?php  
							$website = get_field('website');
							$address = get_field('address'); 
							echo $address['address']; ?> </h6>
					  
						<?php 
						if( !empty($address) ):
                        function urlToDomain($url) {
                        $domain = preg_replace('/https?:\/\/?/', '', $url);
                        if ( strpos($domain, '/') !== false ) {
                        $explode = explode('/', $domain);
                        $domain  = $explode['0'];
                        }
                        return $domain;
                        }
                        ?>
						<p>Telephone number: <?php the_field(telephone);?></p>
                          <p>Website: <a href="<?php echo $website ?>"><?php echo urlToDomain($website); ?></a></p>
                        <p>This practice is a member of: <?php $ccg = get_field('ccg'); echo $ccg['label'] ?></p>
			  			<p>This practice is a member of: <?php $neighbourhood = get_field('neighbourhood'); echo $neighbourhood['label'] ?></p>
			  			<div class="acf-map">
							<div class="marker" data-lat="<?php echo $address['lat']; ?>" data-lng="<?php echo $address['lng']; ?>"></div>
						</div>
<?php endif; ?>
<div class="cqc-widget">
<script type="text/javascript" src="//www.cqc.org.uk/sites/all/modules/custom/cqc_widget/widget.js?data-id=<?php echo get_field('cqc');?>&data-host=www.cqc.org.uk&type=location"></script></div>
	</main><!-- #main -->

<?php

    endwhile; // End of the loop.

?>
			</div>
			  <?php
get_sidebar();
get_footer();