<?php
/**
 * Template Name: Document Library Editor
 *
 * Use this template to display all documents.
 * 
 * @package HitMag
 */

get_header(); 

    while ( have_posts() ) : the_post(); ?>
		
        <main id="main" class="site-main whoswho_page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			  
			  <header class="entry-header">
		<?php

			hitmag_category_list();

		the_title( '<span class="entry-title-container"><h1 class="entry-title">', '</h1></span>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		
		<?php ; endif ?>

	</header><!-- .entry-header -->
			
			 <?php the_content();?> 
			  
			
				
            <?php // Get total number of posts in post-type-name
            
            $docTopic = sanitize_text_field (get_query_var('DocTopic', '25')); 
           
            
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $doclibraryPage = new WP_Query(array(
			  'post_type' => array('wpfb_filepage'),
	          'post_status' => array('published'),
	          'posts_per_page' => 100,
	          'order' => 'ASC',
              'orderby' => 'title',
              'tax_query' => array(
                array(
                 'taxonomy' => 'wpfb_file_category',
                 'field' => 'term_id',
                 'terms' => array($docTopic),
                   ),
                ),
			  'paged' => $paged,  
            ));
              
            
	        $total_posts = $doclibraryPage->found_posts;
	        
            echo '<span class="doc-library__count">' . number_format($total_posts) . '</span> documents in library. '; ?>		
              <ul class="doc-library__list"> <?php
			  
            while($doclibraryPage->have_posts()) {  $doclibraryPage->the_post(); 
                
                ?>
			  	                    
                <li class="doc-library__item" data-id="<?php the_id();?>">
                    <div class="doc-library-editor__container">
                        <div class="doc-library-editor__image">
                            <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'file_url', true ) ); ?>" target="_blank">
                                <img class="thumb" src="<?php echo esc_url( get_post_meta( get_the_ID(), 'file_icon_url', true ) ); ?>" alt="<?php the_title_attribute(); ?>" />
                            </a>
                        </div>
                        <div class="doc-library-editor__content">
                            <input readonly class="note-title-field" value="<?php echo esc_attr(the_title());?>">
                            <span class="doc-library-editor__meta">Date: <?php echo get_the_date() ?> | Topic: 
                            <?php $terms = get_the_terms( $post->ID, 'wpfb_file_category' ); 
                            foreach($terms as $term) { echo $term->name;}?></span> <br>
                            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                            <span class="update-note"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                            <span class="delete-note"><i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                        </div>
                    </div> 
                </li>
			  <?php } 
                
			  endwhile; ?>
                    
                    </ul>
                
                <?php
                
                
              if (function_exists('custom_pagination')) { ?>
    <div class="custom-pagination">
        <?php custom_pagination($doclibraryPage->max_num_pages, "", $paged); ?>
    </div>
			  <?php } ?>
			    
             
								</section> <!-- end article section -->
	
						
						    </article> <!-- end article -->

        </main>

        <aside id="secondary" class="widget-area" role="complementary">
	
        <form method="GET">
            <label for="DocTopic" class="doclibrary-filter--label">Topic</label>
      <select name="DocTopic" id="DocTopic" class="doclibrary-filter--select">
        <option value = "25" >Select Topic</option>
        <option value = "164">Commissioning plan</option>
        <option value = "171">Corporate documents</option>
        <option value = "185">Equality and inclusion</option>
        <option value = "168">Engagement reports</option>
        <option value = "26">Policies and Procedures</option>
        <option value = "43">  - Blackpool CCG</option>
        <option value = "44">  - Fylde and Wyre CCG</option>
        <option value = "31">Strategies</option>
        <option value = "62">Lists and registers</option>
        <option value = "177">Medicines optimisation</option>
        <option value = "179">  - Blackpool CCG</option>
        <option value = "178">  - Fylde and Wyre CCG</option>
      </select>
        <button class="doclibrary-filter--button">Submit</button>
  </form>
    </aside><!-- #secondary -->
<?php 
get_footer();