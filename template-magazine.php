<?php
/**
 * Template Name: Magazine Homepage
 *
 * Displays the Magazine Template of the theme.
 * 
 * @package HitMag
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<a class="covid-link" href="https://www.fyldecoastccgs.nhs.uk/local-services/coronavirus/">
			<div class="covid-container">
				<div class="row">
					<div class="col col-2">
						<img class="covid-HMlogo" src="https://www.fyldecoastccgs.nhs.uk/wp-content/uploads/2020/04/HMlogo.png">
					</div>
					<div class="col col-4">
						<span class="covid-text covid-text--green">Coronavirus</span><br />
						<span class="covid-text">Stay&nbsp;home, </span><span class="covid-text">protect&nbsp;the&nbsp;NHS, </span><br /><span class="covid-text">Save&nbsp;lives</span>
					</div>
					<div class="col col-1">
						<img class="covid-NHSlogo" src="https://www.fyldecoastccgs.nhs.uk/wp-content/uploads/2020/04/nhslogo.png">
					</div>
				</div>
			</div></a>
        <?php

            get_template_part( 'template-parts/featured-slider' );

            if( is_active_sidebar( 'magazine' ) ) {
                dynamic_sidebar( 'magazine' );
            } else {

                if ( current_user_can( 'edit_theme_options' ) ) : ?>

                    <p>
                        <?php esc_html_e( 'Please go to Appearance &#8594; Widgets and add posts widgets to the "Magazine Homepage" widget area. You can use the Magazine Posts widgets to set up the theme like the demo website.', 'hitmag' ); ?>
                    </p>

			    <?php endif;

            }

        ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar('2');
get_footer();