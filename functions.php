<?php

function fyldecoastccgsQueryVars($vars) {
    $vars[] = 'DocTopic';
    $vars[] = 'DocKeyword';
    $vars[] = 'orderBy';
    return $vars;
  }
  
  add_filter('query_vars', 'fyldecoastccgsQueryVars');

require get_theme_file_path( '/inc/functions/search-route.php' );

function fyldecoastccgs_doclibrary_rest() {
    
    register_rest_field('wpfb_filepage', 'authorName', array(
    'get_callback' => function() {get_the_author();}
));    
}

    
add_action('rest_api_init', 'fyldecoastccgs_doclibrary_rest');

function fyldeCoastCCG_files() {
    
	wp_enqueue_style('FontAwesome', '//use.fontawesome.com/releases/v5.6.3/css/all.css');
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyB0SyBBAol1HZW64OQjRQPK3yaii9W9YaE', NULL, '1.0', true);
	wp_enqueue_style('fyldecoastccgs-css', get_theme_file_uri('/style/css/app.css'), array(), false, 'all');
    wp_enqueue_script('fyldecoastccgs-js', get_theme_file_uri('/inc/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_localize_script('fyldecoastccgs-js', 'fyldecoastccgsData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'fyldeCoastCCG_files');

/*Front page sidebar*/

function header_widgets_init() {
	register_sidebar( array(
			'name'          => esc_html__( 'Front Page Sidebar', 'hitmag' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'hitmag' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
}
add_action( 'widgets_init', 'header_widgets_init' );

/*custom post meta*/

function wpb_last_updated_date( $content ) {
$u_time = get_the_time('U'); 
$u_modified_time = get_the_modified_time('U');
$u_author = get_the_modified_author();
if ($u_modified_time >= $u_time) { 
$updated_date = get_the_modified_time('j F Y');
$updated_time = get_the_modified_time('H:i'); 
$custom_content .= '<p class="last-updated">Last updated on '. $updated_date . ' at '. $updated_time . ' by ' . $u_author . '</p>';  
} 
 
    $custom_content .= $content;
    return $custom_content;
}

/*breadcrumb*/

function custom_breadcrumbs() {
       
    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

// custom image sizes

add_image_size ('whoswho-small', 150, 200, true);
add_image_size ('whoswho-large', 240, 320, true);


//Google Maps API

function my_acf_google_map_api($api){
	
	$api['key'] =  'AIzaSyB0SyBBAol1HZW64OQjRQPK3yaii9W9YaE';
		return $api;
	}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// custom post type pagination

function custom_pagination($numpages = '', $pagerange = '', $paged='') {
 
    if (empty($pagerange)) {
        $pagerange = 2;
    }
 
    global $paged;
     
    if (empty($paged)) {
        $paged = 1;
    }
     
    if ($numpages == '') {
        global $wp_query;
         
        $numpages = $wp_query->max_num_pages;
         
        if(!$numpages) {
            $numpages = 1;
        }
    }
 
    $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => True,
        'prev_text'       => __('&laquo;'),
        'next_text'       => __('&raquo;'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
    );
 
    $paginate_links = paginate_links($pagination_args);
 
    if ($paginate_links) {
        echo "<div class='pagination'>";
        echo "<div class='left'>Page " . $paged . " of " . $numpages . "</div> ";
        echo "<div class='right'>" . $paginate_links . "</div> ";
        echo "</div>";
    }
}
require get_theme_file_path( '/inc/functions/shortcodes.php' );
require get_theme_file_path( '/inc/functions/accordion/accordion-shortcode.php' );
require get_theme_file_path( '/inc/functions/post_types.php' );

// Login Screen amendments

function restrict_admin()
{
    if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
                wp_redirect( site_url() );
    }
}
add_action( 'admin_init', 'restrict_admin', 1 );

function login_checked_remember_me() {
    add_filter( 'login_footer', 'rememberme_checked' );
    }
    add_action( 'init', 'login_checked_remember_me' );
    
    function rememberme_checked() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
    }

function my_login_logo_one() { 
    ?> 
    <style type="text/css"> 
    body.login div#login h1 a {
        background-image: url(https://intranet.fyldecoastccgs.nhs.uk/wp-content/uploads/2019/07/logo.png);
        background-size: contain;
        padding-bottom: 5px; 
        width: 300px;
        height: 100px;} 
    </style>
        <?php 
    } add_action( 'login_enqueue_scripts', 'my_login_logo_one' );

function custom_loginfooter() { ?>
    <p>
    <a style="text-decoration:none; display:block; margin-bottom: 20px; font-weight:bold" href="https://insight.fyldecoastccgs.nhs.uk/view.php?id=25184" target="_blank">Don't have a login? Register now!</a>    </p>
<?php }
add_action('login_form','custom_loginfooter');

add_filter( 'password_hint', function( $hint )
{
  return __( "Hint: The password should be at least eight characters long. To make it stronger, use upper and lower case letters and numbers.  If your chosen password is weak don't worry.  Simply tick the 'use weak password' box." );
} );

add_action('login_enqueue_scripts', function(){
    wp_dequeue_script('user-profile');
    wp_dequeue_script('password-strength-meter');
    wp_deregister_script('user-profile');
    
    $suffix = SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_script( 'user-profile', "/wp-admin/js/user-profile$suffix.js", array( 'jquery', 'wp-util' ), false, 1 );
    });

// hide dashboard to subscribers
add_action('admin_init', 'disable_dashboard');

function disable_dashboard() {
    if (current_user_can('subscriber') && is_admin()) {
        wp_redirect(home_url());
        exit;
    }
}

?>