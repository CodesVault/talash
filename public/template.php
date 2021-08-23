<div class="searchify" id="searchify">
	<a id="searchify-select" href="#searchify"></a>
	<div class="searchify-overlay"></div>

	<form id="searchify-form">
		<div class="search-bar">
			<div class="search-bar__inner" searchify-tooltip="CTRL + SHIFT + F">
				<input class="search-bar__input" name="searchifySearch" type="text" data-key="<?php echo esc_attr( 'Key' ); ?>" placeholder="Search" autocomplete="off">
				<div class="search-bar__clear-input" searchify-tooltip="Clear">x</div>
			</div>
			<button type="submit" class="search-bar__btn-search" searchify-tooltip="Search">
				<svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="20px" height="20px">
					<path d="M21,3C11.6,3,4,10.6,4,20s7.6,17,17,17s17-7.6,17-17S30.4,3,21,3z M21,33c-7.2,0-13-5.8-13-13c0-7.2,5.8-13,13-13c7.2,0,13,5.8,13,13C34,27.2,28.2,33,21,33z"/>
					<path fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="6" d="M31.2 31.2L44.5 44.5"/>
				</svg>
			</button>
		</div>

		<div class="searchify-advanced">
			<div class="searchify-advanced__inner">

				<div class="post-type-list">
					<div class="postType-label" data-label="<?php echo esc_attr__( 'Post Type', 'searchify' ); ?>">
						<?php _e( 'Post Type', 'searchify' ); ?>
					</div>
					<input type="text" name="postType" id="postType-data">
				</div>

				<div class="category-list">
					<div class="cat-label" data-label="<?php echo esc_attr__( 'Category', 'searchify' ); ?>">
						<?php _e( 'Category', 'searchify' ); ?>
					</div>
					<input type="text" name="catID" id="cat-data">
				</div>

				<div class="date-range">
					<div class="date-range__input">
						<input type="text" class="dateRange dateRangeStart" name="dateRangeStart" value="" readonly>
						<input type="text" class="dateRange dateRangeEnd" name="dateRangeEnd" value="" readonly>
						<span></span>
					</div>
				</div>

				<div class="author-list">
					<div class="author-label" data-label="<?php echo esc_attr__( 'Author', 'searchify' ); ?>">
						<?php _e( 'Author', 'searchify' ); ?>
					</div>
					<input type="text" name="authorID" id="author-data">
				</div>
			</div>

			<!-- popups -->
			<div class="searchify-inner-popup" id="postType-popup">
				<div class="searchify-loader" id="postType-loader"><div></div></div>
				<div class="searchify-popup__input-close" id="postType-close"><a searchify-tooltip="Close">x</a></div>
				<div id="postType-popup__input" class="searchify-popup__input"></div>
			</div>
			<div class="searchify-inner-popup" id="cat-popup">
				<div class="searchify-loader" id="cat-loader"><div></div></div>
				<div class="searchify-popup__input-close" id="cat-close"><a searchify-tooltip="Close">x</a></div>
				<div id="cat-popup__input" class="searchify-popup__input"></div>
			</div>
			<div class="searchify-inner-popup" id="author-popup">
				<div class="searchify-loader" id="author-loader"><div></div></div>
				<div class="searchify-popup__input-close" id="author-close"><a searchify-tooltip="Close">x</a></div>
				<div id="author-popup__input" class="searchify-popup__input" data-avatar-url="<?php echo esc_attr( TALASH_URL . 'assets/images/searchify-placeholder.png' ); ?>"></div>
			</div>

			<div class="searchify-reset-wrapper">
				<a class="searchify-reset"><?php _e( 'Reset', 'searchify' ); ?></a>
			</div>

		</div>

		<div class="searchify-result">
			<div class="searchify-result__header">
				<div class="searchify-search-by" data-search-by=""><?php _e( 'Searched by', 'searchify' ); ?></div>
				<div class="searchify-result-close"><a searchify-search-tooltip="Close">x</a></div>
			</div>
			<div class="searchify-loader" id="search-loader"><div></div></div>
			<div class="searchify-result__inner"></div>
		</div>
	</form>
</div>
