<?php

class Talash_Heading_Control extends WP_Customize_Control {
	public $type = 'separator';

	public function render_content() {
		?>
		<label class="talash-heading">
			<h4 class="talash-customize-control-separator">
				<?php echo esc_html( $this->label ); ?>
			</h4>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</label>
		<?php
	}
}
