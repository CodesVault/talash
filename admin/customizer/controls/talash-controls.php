<?php
require TALASH_DIR_PATH . 'admin/customizer/controls/partials/input-field.php';
require TALASH_DIR_PATH . 'admin/customizer/controls/partials/search-button.php';
require TALASH_DIR_PATH . 'admin/customizer/controls/partials/dropdowns.php';
require TALASH_DIR_PATH . 'admin/customizer/controls/partials/search-result.php';

function searchify_customizer_controls($wp_customize) {
	input_field($wp_customize);
	search_button($wp_customize);
	dropdowns($wp_customize);
	search_result($wp_customize);	
}
