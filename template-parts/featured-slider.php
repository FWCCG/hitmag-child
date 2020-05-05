<?php 
if ( true == get_theme_mod( 'show_slider', true ) ) :

    $hm_slider_category = get_theme_mod( 'slider_category', '0' );

    $slider_posts = new WP_Query (
        array(
            'cat'                   => $hm_slider_category,
            'posts_per_page'        => 10,
            'ignore_sticky_posts'   => false
        )
    )

    ?>

    <div class="hitmag-featured-slider">
        <section class="slider">
            <div id="hm-slider" class="flexslider">
                <ul class="slides">
                    <?php
                        if ( $slider_posts->have_posts() ) :
                        while( $slider_posts->have_posts() ) : $slider_posts->the_post();

                        if ( has_post_thumbnail() ) {
                            $thumb_id               = get_post_thumbnail_id();
                            $featured_url_array     = wp_get_attachment_image_src( $thumb_id, 'hitmag-featured' );
                            $featured_image_url     = $featured_url_array[0];
                            $featured_image_alt     = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
                        } else {
                            $stylesheetdirectory    = get_bloginfo('stylesheet_directory');
                            $featured_image_url     = $stylesheetdirectory . '/images/default-slide-image.jpg';
                        }
                    ?>
                        <li>
                            <div class="hm-slider-container" data-loc="<?php echo esc_url( get_permalink() ); ?>">

                                <div class="hm-slide-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);">

                                    <div class="hm-slide-content">

                                        <div class="hm-slider-details">
                                            <?php hitmag_category_list(); ?>
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"><h3 class="hm-slider-title"><?php the_title(); ?></h3></a>
                                            <div class="slide-entry-meta">
                                                <?php hitmag_posted_on(); ?>
                                            </div><!-- .entry-meta -->
                                        </div><!-- .hm-slider-details -->

                                    </div><!-- .hm-slide-content -->

                                </div><!-- .hm-slide-holder -->

                            </div><!-- .hm-slider-container -->
                        </li>

                    <?php 

                        endwhile;
                        endif;

                    ?>
                </ul>
            </div><!-- .flexslider -->
        </section><!-- .slider -->

        <?php $slider_posts->rewind_posts(); ?>

        <div id="hm-carousel" class="flexslider">
            <ul class="slides">
                <?php
                    if ( $slider_posts->have_posts() ) :
                        while( $slider_posts->have_posts() ) : $slider_posts->the_post();

                            if ( has_post_thumbnail() ) {
                                $stylesheetdirectory    = get_bloginfo('stylesheet_directory');
                                $thumb_id               = get_post_thumbnail_id();
                                $thumb_url_array        = wp_get_attachment_image_src( $thumb_id, 'hitmag-thumbnail' );
                                $thumb_url              = $thumb_url_array[0];
                                $thumb_alt              = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
                            } else {
                                $thumb_url = $stylesheetdirectory . '/images/default-slide-image-thumb.jpg';
                            }
                        ?>

                        <li>
                            <div class="hm-thumb-bg"><img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo ( $thumb_alt ); ?>" /><span class="screen-reader-text"><?php the_title(); ?></span></div>
                        </li>

                    <?php 
                        endwhile; 
                    endif; 
                    wp_reset_postdata(); 
                ?>
            </ul><!-- .slides -->
        </div><!-- #hm-carousel -->

    </div><!-- .hm-slider -->

<?php endif;