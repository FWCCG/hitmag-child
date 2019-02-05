<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

get_header(); ?>
<script type="text/javascript">
(function($) {
var infoWindows = new Array();
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
	
	// KML layer
    
    var kmlLayer = new google.maps.KmlLayer();
    var src = 'https://www.fyldecoastccgs.nhs.uk/wp-content/themes/hitmag-child/inc/map-data/CCG_boundary.kml';
    var kmlLayer = new google.maps.KmlLayer(src, {
    suppressInfoWindows: true,
    preserveViewport: false,
    map: map
});
    
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
			var infoWindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});
			
			infoWindows.push(infoWindow);
	
			// show info window when marker is clicked
			google.maps.event.addListener(marker, 'click', function() {

				//close all
				for (var i = 0; i < infoWindows.length; i++) {
				  infoWindows[i].close();
				}
																	
				infoWindow.open( map, marker );
			});
			
			google.maps.event.addListener(map, 'click', function() {
				infoWindow.close();
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

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			<header class="entry-header page-header">
			<span class="entry-title-container"><h1 class="page-title entry-title">GP Practices</h1></span>
			</header><!-- .page-header -->

				<div class="acf-map">
				
				<?php query_posts('showposts=-1&post_type=practice'); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
				
				$address = get_field('address');?>
			
			<div class="marker" data-lat="<?php echo $address['lat']; ?>" data-lng="<?php echo $address['lng']; ?>">
				<h4><a href="<?php the_field(website); ?>"><?php the_title(); ?></a></h4>
				<p class="address"><?php echo $address['address']; ?></p>
				<p class="address"><?php the_field(telephone);?></p>	
			</div>
			
			<?php endwhile; else: ?>
			
			<p>Sorry, no posts to list</p>

			<?php endif; ?>
			
		</div>

		<div class="practices__container">
				<?php query_posts( array(
				showposts => -1,
				post_type => 'practice',
				orderby => 'title',
				order => ASC,
				)); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
				
				$address = get_field('address');?>
				<div class="whoswho__card practice__card">
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) {
                            the_post_thumbnail('hitmag-featured', array('class'=>'whoswho__floatleft')); 
                        } else { ?>
                        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/default-practice-image.jpg" alt="<?php the_title(); ?>" class="whoswho__floatleft"/>
                        <?php } ?>
                        	<strong><?php the_title();?></strong></a>
				</div>
			
					
			<?php endwhile; else: ?>
			</ul>	
			<p>Sorry, no posts to list</p>

			<?php endif; ?>
		</article>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();