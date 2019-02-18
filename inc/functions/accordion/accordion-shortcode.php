<?php

	function g7_clean_shortcodes($content) {$array = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
		);
		$content = strtr($content, $array);
		return $content;
	}

	add_filter('the_content', 'g7_clean_shortcodes');

	function add_plugin($plugin_array) {
		if (version_compare(get_bloginfo('version'), 3.9, '>=')) {
			$plugin_array['g7_button'] = $this->url . 'js/buttons2.js';
		} else {
			$plugin_array['g7_button'] = $this->url . 'js/buttons2.js';
		}
		return $plugin_array;
	}

	function register_button($buttons) {
		$buttons[] = 'separator';
		$buttons[] = 'sc_button';
		return $buttons;
	}

	function create_accordion_shortcode( $atts , $content = null ) {

		return '<script src="https://code.jquery.com/jquery-1.12.4.js"></script><script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><script>$( function() { $( "#accordion" ).accordion({ active: false, collapsible: true });} ); </script>' . '<div class="peeker-container"><div class="accordion-peeker">Click each header to expand its content</div></div><div id="accordion">' . do_shortcode($content) . '</div>';
	}

	function accordion_shortcode_section( $atts , $content = null ) {

		// Attributes
		$atts = shortcode_atts(
			array(
				'title' => '',
			), $atts);

		return '<h3>' . $atts['title'] . '</h3><div>' . do_shortcode($content) . '</div>';
	}

	
	add_shortcode( 'accordion', 'create_accordion_shortcode' );
	add_shortcode( 'section', 'accordion_shortcode_section' );

?>