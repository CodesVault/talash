;( function( $ ) {

	function talash_wp_customize(key, callback) {
		wp.customize( key, function( value ) {
			value.bind( callback );
		});
	}


	// ********** input field **********
	talash_wp_customize( 
		'talash_input_background_color', 
		function( newval ) {
			$('.search-bar .search-bar__input').css('background-color', newval );
        }
	);

	talash_wp_customize( 
		'talash_input_color', 
		function( newval ) {
			$('.search-bar .search-bar__input').css('color', newval );
			$('.search-bar .search-bar__input::placeholder').css('color', newval );
        }
	);

	talash_wp_customize( 
		'talash_dropdown_input_background_color', 
		function( newval ) {
			$('.search-bar.unfold .search-bar__input').css('background-color', newval );
        }
	);

	// ********** Search Button **********
	talash_wp_customize(
		'talash_button_icon_color',
		function( newval ) {
			$('button.search-bar__btn-search svg').css('fill', newval );
			$('button.search-bar__btn-search path').css('stroke', newval );
        }
	);
	talash_wp_customize(
		'talash_dropdown_button_icon_color',
		function( newval ) {
			$('.search-bar.unfold button.search-bar__btn-search svg').css('fill', newval );
			$('.search-bar.unfold button.search-bar__btn-search path').css('stroke', newval );
        }
	);

	talash_wp_customize(
		'talash_button_background_color',
		function( newval ) {
			$('.talash form .search-bar button.search-bar__btn-search').css('background-color', newval );
        }
	);

	talash_wp_customize(
		'talash_button_hover_background_color',
		function( newval ) {
			$('.talash form .search-bar button.search-bar__btn-search').hover(function() {
				$(this).css('background-color', newval);
			});
		}
	);

	talash_wp_customize(
		'talash_dropdown_button_background_color',
		function( newval ) {
			$('.talash form .search-bar.unfold button.search-bar__btn-search').css('background-color', newval );
        }
	);

	talash_wp_customize(
		'talash_dropdown_background_color', 
		function( newval ) {
			$('.talash-advanced').css('background-color', newval );
			$('.talash-inner-popup.show').css('background-color', newval );
			$('.talash-result__inner.show').css('background-color', newval );
        }
	);

	talash_wp_customize(
		'talash_dropdown_color', 
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

	talash_wp_customize(
		'talash_dropdown_reset_color', 
		function( newval ) {
			$('a.talash-reset').css('color', newval );
			$('.talash-result-close a').css('color', newval );
			$('.talash-popup__input-close a').css('color', newval );
			$('a.talash-reset:hover').css('color', newval );
			$('.talash-result-close a:hover').css('color', newval );
			$('.talash-popup__input-close a:hover').css('color', newval );
        }
	);

	talash_wp_customize(
		'talash_dropdown_progress_bar_color', 
		function( newval ) {
			$('.talash-loader div').css('border-color', newval );
        }
	);

	talash_wp_customize(
		'talash_result_search_by_color', 
		function( newval ) {
			$('.talash-search-by').css('color', newval );
        }
	);

	talash_wp_customize(
		'talash_result_title_color', 
		function( newval ) {
			$('h2.talash-title a').css('color', newval );
        }
	);
	talash_wp_customize(
		'talash_result_title_hover_color',
		function( newval ) {
			$('h2.talash-title a').hover(function() {
				$(this).css('color', newval);
			});
		}
	);

	talash_wp_customize(
		'talash_result_author_color', 
		function( newval ) {
			$('.talash-post-meta .author-meta').css('color', newval );
        }
	);

	talash_wp_customize(
		'talash_result_cat_bg_color', 
		function( newval ) {
			$('.talash-post-meta .cat-meta').css('background-color', newval );
        }
	);

	talash_wp_customize(
		'talash_result_cat_color', 
		function( newval ) {
			$('.talash-post-meta .cat-meta').css('color', newval );
        }
	);

} )( jQuery );
