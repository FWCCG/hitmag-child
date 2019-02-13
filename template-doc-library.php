<?php
/**
 * Template Name: Document Library
 *
 * Use this template to display all documents.
 * 
 * @package HitMag
 */

get_header(); 

    while ( have_posts() ) : the_post(); 
    
    $docTopic = sanitize_text_field (get_query_var('DocTopic', '25'));
    $docKeyword = sanitize_text_field (get_query_var('DocKeyword', '')); 
    $orderBy = sanitize_text_field (get_query_var('orderBy', 'ASC'));
    
    ?>
		
    <aside class="doclibrary-aside">
    <h1 class="doclibrary-title">Document library</h1>
    <p>You can use the filters below to show only documents that match your interests.</p>
    <div class="doclibrary-filtergroup">
    <form method="GET">
      <label for="DocKeyword" class="doclibrary-filter--label">Keyword</label>
      <input type="search" id="filter-keyword" name="DocKeyword" class="doclibrary-filter--input" placeholder="<?php echo $docKeyword ?>">
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
      <label for="orderBy" class="doclibrary-filter--label">Order results by</label>
        <select name="orderBy" id="orderBy" class="doclibrary-filter--select">
          <option value = "" >Select a value</option>
          <option value = "title" >Document name</option>
          <option value = "date" >Date of publication</option>
      </select>
      <button class="doclibrary-filter--button">Submit</button>
  </form>
    </div>
    </aside> 
    
    <main id="main" class="site-main doclibrary-page" role="main">

          <article id="post-<?php the_ID(); ?>" <?php $classes = array('clearfix','hitmag-page'); post_class( $classes ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			
			<?php // Get total number of posts in post-type-name
            $docTopic = sanitize_text_field (get_query_var('DocTopic', '25'));
            $docKeyword = sanitize_text_field (get_query_var('DocKeyword', '')); 
            $orderBy = sanitize_text_field (get_query_var('orderBy', 'ASC'));
     
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $doclibraryPage = new WP_Query(array(
			      'post_type' => array('wpfb_filepage'),
	          'post_status' => array('published'),
	          'posts_per_page' => 10,
            'order' => 'ASC',
            's' => $docKeyword,
	          'orderby' => $orderBy,
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
	        
            echo '<span class="doclibrary-results--count"><span class="doclibrary-results--count-number">' . number_format($total_posts) . '</span> documents in library.</span> '; ?>		
              <ul class="doc-library__list"> <?php
			  
            while($doclibraryPage->have_posts()) {  $doclibraryPage->the_post(); 
                
                ?>
			  	                    
                <li class="doclibrary-results--item"><a href="<?php the_permalink();?>" class="doclibrary-results--title"><?php the_title(); ?></a><br>
                  <span class="doclibrary-results--date"><i class="fa fa-calendar"></i> <?php echo get_the_date() ?></span><br>
                  <span class="doclibrary-results--topics"> 
                      <?php $terms = get_the_terms( $post->ID, 'wpfb_file_category'); $i = 1;
                            foreach($terms as $term) { if( is_wp_error( $term_link ) )
                              continue;
                              echo ('<span class="doclibrary-results--topic">');
                              echo ($term->name);
                              echo ('</span>');
                              //  Add comma (except after the last theme)
                              echo ($i < count($terms))? " " : "";
                              // Increment counter
                              $i++;}?>
                  </span>
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

   
<?php 
get_footer();