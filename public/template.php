<div class="talash" id="talash">
	<a id="talash-select" href="#talash"></a>
	<div class="talash-overlay"></div>

	<form id="talash-form">
		<div class="search-bar">
			<div class="search-bar__inner" talash-tooltip="<?php echo esc_attr( 'CTRL + SHIFT + F' ); ?>">
				<input class="search-bar__input" name="talashKey" type="text" placeholder="<?php echo esc_attr__( 'Search', 'talash' ); ?>" autocomplete="off">
				<div class="search-bar__clear-input" talash-tooltip="<?php echo esc_attr__( 'Clear', 'talash' ); ?>">x</div>
			</div>
			<button type="submit" class="search-bar__btn-search" talash-tooltip="<?php echo esc_attr__( 'Search', 'talash' ); ?>">
				<svg fill="#ffd300" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="20px" height="20px">
					<path d="M21,3C11.6,3,4,10.6,4,20s7.6,17,17,17s17-7.6,17-17S30.4,3,21,3z M21,33c-7.2,0-13-5.8-13-13c0-7.2,5.8-13,13-13c7.2,0,13,5.8,13,13C34,27.2,28.2,33,21,33z"/>
					<path fill="none" stroke="#ffd300" stroke-miterlimit="10" stroke-width="6" d="M31.2 31.2L44.5 44.5"/>
				</svg>
			</button>
		</div>

		<div class="talash-advanced">
			<div class="talash-advanced__inner">

				<div class="post-type-list">
					<div class="postType-label" data-label="<?php echo esc_attr__( 'Post Type', 'talash' ); ?>">
						<?php _e( 'Post Type', 'talash' ); ?>
					</div>
					<input type="text" name="postType" id="postType-data">
				</div>

				<div class="category-list">
					<div class="cat-label" data-label="<?php echo esc_attr__( 'Category', 'talash' ); ?>">
						<?php _e( 'Category', 'talash' ); ?>
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
					<div class="author-label" data-label="<?php echo esc_attr__( 'Author', 'talash' ); ?>">
						<?php _e( 'Author', 'talash' ); ?>
					</div>
					<input type="text" name="authorID" id="author-data">
				</div>
			</div>

			<!-- popups -->
			<div class="talash-inner-popup" id="postType-popup">
				<div class="talash-loader" id="postType-loader"><div></div></div>
				<div class="talash-popup__input-close" id="postType-close">
					<a talash-tooltip="<?php echo esc_attr( 'Close', 'talash' ); ?>"><?php echo esc_html( 'x' ); ?></a>
				</div>
				<div id="postType-popup__input" class="talash-popup__input"></div>
			</div>
			<div class="talash-inner-popup" id="cat-popup">
				<div class="talash-loader" id="cat-loader"><div></div></div>
				<div class="talash-popup__input-close" id="cat-close">
					<a talash-tooltip="<?php echo esc_attr__( 'Close', 'talash' ); ?>"><?php echo esc_html( 'x' ); ?></a>
				</div>
				<div id="cat-popup__input" class="talash-popup__input"></div>
			</div>
			<div class="talash-inner-popup" id="author-popup">
				<div class="talash-loader" id="author-loader"><div></div></div>
				<div class="talash-popup__input-close" id="author-close">
					<a talash-tooltip="<?php echo esc_attr__( 'Close', 'talash' ); ?>"><?php echo esc_html( 'x' ); ?></a>
				</div>
				<div id="author-popup__input" class="talash-popup__input" data-avatar-url="<?php echo esc_url( TALASH_URL . 'assets/images/talash-placeholder.png' ); ?>"></div>
			</div>

			<div class="talash-reset-wrapper">
				<a class="talash-reset"><?php esc_html_e( 'Reset', 'talash' ); ?></a>
			</div>

		</div>

		<div class="talash-result">
			<div class="talash-result__header">
				<div class="talash-search-by" data-search-by=""><?php esc_html_e( 'Searched by', 'talash' ); ?></div>
				<div class="talash-result-close">
					<a talash-search-tooltip="<?php echo esc_attr__( 'Close', 'talash' ); ?>"><?php echo esc_html( 'x' ); ?></a>
				</div>
			</div>
			<div class="talash-loader" id="search-loader"><div></div></div>
			<div class="talash-result__inner"></div>
		</div>
	</form>
</div>
