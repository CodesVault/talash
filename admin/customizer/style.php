<?php 

function talash_customizer_editor_styles() { ?>
	<style type="text/css">
		.talash-heading h4 {
			font-size: 20px;
			font-weight: 500;
			margin-top: 35px;
			margin-bottom: 0; 
			padding: 10px; 
			background-color: rgba(255, 211, 0, .10);
    		border-top: 2px solid #ffd300;
		}
	</style>
	<?php 
}
add_action( 'customize_controls_print_styles', 'talash_customizer_editor_styles', 999 );


function talash_customizer_style() {
	?>
	<style type="text/css">
		/* === input field === */
		.search-bar .search-bar__input {
			background-color: <?php echo get_theme_mod( 'searchify_input_background_color', '' ); ?>;
			color: <?php echo get_theme_mod( 'searchify_input_color', '' ); ?>;
		}
		.search-bar.unfold .search-bar__input {
			background-color: <?php echo get_theme_mod( 'searchify_dropdown_input_background_color', '' ); ?>;
		}

		.search-bar .search-bar__input:focus,
		.search-bar .search-bar__input::placeholder {
			color: <?php echo get_theme_mod( 'searchify_input_color', '' ); ?>;
		}

		/* === search button === */
		button.search-bar__btn-search svg {
			fill: <?php echo get_theme_mod( 'searchify_button_icon_color', '' ); ?>;
		}
		button.search-bar__btn-search path {
			stroke: <?php echo get_theme_mod( 'searchify_button_icon_color', '' ); ?>;
		}
		.search-bar.unfold button.search-bar__btn-search svg {
			fill: <?php echo get_theme_mod( 'searchify_dropdown_button_icon_color', '' ); ?>;
		}
		.search-bar.unfold button.search-bar__btn-search path {
			stroke: <?php echo get_theme_mod( 'searchify_dropdown_button_icon_color', '' ); ?>;
		}

		.searctalashhify form .search-bar button.search-bar__btn-search {
			background-color: <?php echo get_theme_mod( 'searchify_button_background_color', '' ); ?>;
		}
		.talash form .search-bar.unfold button.search-bar__btn-search {
			background-color: <?php echo get_theme_mod( 'searchify_dropdown_button_background_color', '' ); ?>;
		}
		.talash form .search-bar.unfold button.search-bar__btn-search:hover,
		.talash form .search-bar button.search-bar__btn-search:hover {
			background-color: <?php echo get_theme_mod( 'searchify_button_hover_background_color', '' ); ?>;
		}

		/* === popup === */
		.talash-advanced,
		.talash-inner-popup.show,
		.talash-result.show {
			background-color: <?php echo get_theme_mod( 'searchify_dropdown_background_color', '' ); ?>;
		}

		.post-type-list .postType-label,
		.category-list .cat-label,
		.author-list .author-label,
		.post-type-li__inner,
		.cat-li__inner,
		.date-range .date-range__input,
		.author-li__inner {
			color: <?php echo get_theme_mod( 'searchify_dropdown_color', '' ); ?>;
		}

		a.talash-reset,
		.talash-result-close a,
		.talash-popup__input-close a,
		a.talash-reset:hover,
		.talash-result-close a:hover,
		.talash-popup__input-close a:hover {
			color: <?php echo get_theme_mod( 'searchify_dropdown_reset_color', '' ); ?>;
		}
		a.talash-reset:hover,
		.talash-result-close a:hover,
		.talash-popup__input-close a:hover {
			opacity: .8;
		}

		.talash-loader div {
			border-color: <?php echo get_theme_mod( 'searchify_dropdown_progress_bar_color', '' ); ?>;
		}

		/* === search result === */
		.talash-search-by {
			color: <?php echo get_theme_mod( 'searchify_result_search_by_color', '' ); ?>;
		}

		h2.talash-title a {
			color: <?php echo get_theme_mod( 'searchify_result_title_color', '' ); ?>;
		}
		h2.talash-title a:hover {
			color: <?php echo get_theme_mod( 'searchify_result_title_hover_color', '' ); ?>;
		}

		.talash-post-meta .author-meta {
			color: <?php echo get_theme_mod( 'searchify_result_author_color', '' ); ?>;
		}

		.talash-post-meta .cat-meta {
			background-color: <?php echo get_theme_mod( 'searchify_result_cat_bg_color', '' ); ?>;
		}
		.talash-post-meta .cat-meta {
			color: <?php echo get_theme_mod( 'searchify_result_cat_color', '' ); ?>;
		}
	</style>
	<?php 
}
add_action( 'wp_head', 'talash_customizer_style' );
