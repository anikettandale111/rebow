<?php

if ( ! function_exists( 'logincust_padding_control' ) ) :

	function logincust_padding_control( $wp_customize ) {
		class LoginCust_Padding_Control extends WP_Customize_Control {

			public $type = 'logincust-padding';

			public function enqueue() {
				wp_enqueue_script( 'logincust-padding', LOGINCUST_FREE_URL . 'inc/customizer/controls/padding/assets/js/padding-control.js', '', '', true );
				wp_enqueue_style( 'logincust-padding', LOGINCUST_FREE_URL . 'inc/customizer/controls/padding/assets/css/padding-control.css' );
			}

			public function render_content() {
				?>
				<label>
					<div id="<?php echo esc_attr( $this->id ); ?>">
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
						<?php endif; ?>
						<div class="field-area">
							<div class="field-icon"><i class="dashicons dashicons-arrow-up"></i><?php _e( 'Top', 'login-customizer' ); ?></div>
							<input type="number" value="10" min="0" max="1000" />
							<div class="field-icon"><i class="dashicons dashicons-arrow-right"></i><?php _e( 'Right', 'login-customizer' ); ?></div>
							<input type="number" value="10" min="0" max="1000" />
						</div>
						<div class="field-area">
							<div class="field-icon"><i class="dashicons dashicons-arrow-down"></i><?php _e( 'Down', 'login-customizer' ); ?></div>
							<input type="number" value="10" min="0" max="1000" />
							<div class="field-icon"><i class="dashicons dashicons-arrow-left"></i><?php _e( 'Left', 'login-customizer' ); ?></div>
							<input type="number" value="10" min="0" max="1000" />
						</div>
						<input type="text" value="<?php echo esc_html( $this->value() ); ?>" <?php $this->link(); ?> />
					</div>
				</label>
				<?php
			}

		}
	}
	add_action( 'customize_register', 'logincust_padding_control' );

endif;
