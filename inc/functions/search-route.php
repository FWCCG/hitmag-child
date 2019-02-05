<?php
/* change amount of posts returned by REST API to 100 */
function rest_posts_per_page( $args, $request ) {
    $max = max( (int)$request->get_param( 'per_page' ), 100 );
    $args['posts_per_page'] = $max;
    return $args;
}
add_filter( 'rest_post_query', 'rest_posts_per_page', 10, 2 );

add_action( 'rest_api_init', 'fyldecoastccgsRegisterSearch');

function fyldecoastccgsRegisterSearch() {
    register_rest_route( 'fyldecoast/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'fyldecoastSearchResults',
    ) );
}

function fyldecoastSearchResults ($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'event', 'wpfb_filepage'),
        's' => sanitize_text_field( $data['term'] ),
    ));

    $results = array(
        'generalInfo' => array(),
        'news' => array(),
        'events' => array(),
        'staff' => array(),
        'documents' => array(),
    );

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        
        if (get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'ID' => get_the_ID(),
                'title' => get_the_title(),
                'content' => wp_filter_nohtml_kses(get_the_content()),
                'type' => get_post_type(),
                'url' => get_the_permalink(),
                'thumbnail' => get_the_post_thumbnail_url()
            ));
        }

        if (get_post_type() == 'post') {
            array_push($results['news'], array(
                'title' => get_the_title(),
                'content' => wp_filter_nohtml_kses(get_the_content()),
                'type' => get_post_type(),
                'url' => get_the_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(),
            ));
        }
          
        if (get_post_type() == 'event') {
            array_push($results['events'], array(
                'title' => get_the_title(),
                'type' => get_post_type(),
                'url' => get_the_permalink(),
                'description' => get_the_content(),
                'thumbnail' => get_the_post_thumbnail_url()
            ));     
        }

        if (get_post_type() == 'staff') {
                array_push($results['staff'], array(
                    'title' => get_the_title(),
                    'type' => get_post_type(),
                    'url' => get_the_permalink(),
                    'description' => get_the_content(),
                    'thumbnail' => get_the_post_thumbnail_url()
                ));     
        }

        if (get_post_type() == 'wpfb_filepage') {
            array_push($results['documents'], array(
                'title' => get_the_title(),
                'type' => get_post_type(),
                'url' => get_the_permalink(),
                'description' => get_the_content(),
                'thumbnail' => get_post_meta( get_the_ID(), 'file_icon_url', true )
            ));     
    }
    }

    return $results;
}



?>