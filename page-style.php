<?php
/*
Plugin Name: Page Style
Plugin URI: http://vinicius.borriello.com.br/page-style.php
Version: 1.0
Author: Vinícius Borriello
Author URI: http://vinicius.borriello.com.br
Description: Allow pages/categories to have different styles by adding a CSS Class (Page/Category Slug) to the BODY tag
*/

// Init function
function pageStyle_init() {
	wp_enqueue_script("jquery");
	add_action("wp_footer", "pageStyle_addStyle");
}

// Function Add Style
function pageStyle_addStyle() {
	global $post;
	
	if (is_home()) :
		$class = "home";
	elseif (is_search()) :
		$class = "search";
	elseif (is_single() || is_page()) :
		$class = $post->post_name;
	elseif (is_date()) :
		$class = "archive";
		if (is_year()) :
			$class .= " year";
		elseif (is_month()) :
			$class .= " month";
		elseif (is_day()) :
			$class .= " day";
		endif;
	elseif (is_author()) :
		$class = "author";
	elseif (is_404()) :
		$class = "404";
	elseif (is_category()) :
		$class = get_the_category($post->ID);
	endif;
	
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$("BODY").addClass("<?php echo $class; ?>");
		});
	</script>
<?php
}
add_action("get_footer", "pageStyle_addStyle");

// Init
add_action('init', "pageStyle_init");
?>