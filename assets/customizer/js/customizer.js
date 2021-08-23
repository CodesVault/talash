;( function( $ ) {

	function searchify_wp_customize(key, callback) {
		wp.customize( key, function( value ) {
			value.bind( callback );
		});
	}


	// ********** input field **********
	searchify_wp_customize( 
		'searchify_input_background_color', 
		function( newval ) {
			$('.search-bar .search-bar__input').css('background-color', newval );
        }
	);

	searchify_wp_customize( 
		'searchify_input_color', 
		function( newval ) {
			$('.search-bar .search-bar__input').css('color', newval );
			$('.search-bar .search-bar__input::placeholder').css('color', newval );
        }
	);

	searchify_wp_customize( 
		'searchify_dropdown_input_background_color', 
		function( newval ) {
			$('.search-bar.unfold .search-bar__input').css('background-color', newval );
        }
	);

	// ********** Search Button **********
	searchify_wp_customize(
		'searchify_button_icon_color',
		function( newval ) {
			$('button.search-bar__btn-search svg').css('fill', newval );
			$('button.search-bar__btn-search path').css('stroke', newval );
        }
	);
	searchify_wp_customize(
		'searchify_dropdown_button_icon_color',
		function( newval ) {
			$('.search-bar.unfold button.search-bar__btn-search svg').css('fill', newval );
			$('.search-bar.unfold button.search-bar__btn-search path').css('stroke', newval );
        }
	);

	searchify_wp_customize(
		'searchify_button_background_color',
		function( newval ) {
			$('.searchify form .search-bar button.search-bar__btn-search').css('background-color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_button_hover_background_color',
		function( newval ) {
			$('.searchify form .search-bar button.search-bar__btn-search').hover(function() {
				$(this).css('background-color', newval);
			});
		}
	);

	searchify_wp_customize(
		'searchify_dropdown_button_background_color',
		function( newval ) {
			$('.searchify form .search-bar.unfold button.search-bar__btn-search').css('background-color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_dropdown_background_color', 
		function( newval ) {
			$('.searchify-advanced').css('background-color', newval );
			$('.searchify-inner-popup.show').css('background-color', newval );
			$('.searchify-result__inner.show').css('background-color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_dropdown_color', 
		function( newval ) {
			$('.post-type-list .postType-label').css('color', newval );
			$('.category-list .cat-label').css('color', newval );
			$('.author-list .author-label').css('color', newval );
			$('.post-type-li__inner').css('color', newval );
			$('.cat-li__inner').css('color', newval );
			$('.date-range .date-range__input').css('color', newval );
			$('.author-li__inner').css('color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_dropdown_reset_color', 
		function( newval ) {
			$('a.searchify-reset').css('color', newval );
			$('.searchify-result-close a').css('color', newval );
			$('.searchify-popup__input-close a').css('color', newval );
			$('a.searchify-reset:hover').css('color', newval );
			$('.searchify-result-close a:hover').css('color', newval );
			$('.searchify-popup__input-close a:hover').css('color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_dropdown_progress_bar_color', 
		function( newval ) {
			$('.searchify-loader div').css('border-color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_result_search_by_color', 
		function( newval ) {
			$('.searchify-search-by').css('color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_result_title_color', 
		function( newval ) {
			$('h2.searchify-title a').css('color', newval );
        }
	);
	searchify_wp_customize(
		'searchify_result_title_hover_color',
		function( newval ) {
			$('h2.searchify-title a').hover(function() {
				$(this).css('color', newval);
			});
		}
	);

	searchify_wp_customize(
		'searchify_result_author_color', 
		function( newval ) {
			$('.searchify-post-meta .author-meta').css('color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_result_cat_bg_color', 
		function( newval ) {
			$('.searchify-post-meta .cat-meta').css('background-color', newval );
        }
	);

	searchify_wp_customize(
		'searchify_result_cat_color', 
		function( newval ) {
			$('.searchify-post-meta .cat-meta').css('color', newval );
        }
	);

} )( jQuery );
