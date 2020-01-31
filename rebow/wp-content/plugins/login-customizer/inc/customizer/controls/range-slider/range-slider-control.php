<?php
/**
 * Range Slider Customizer Control - Modified version of O2 Customizer Library
 *
 * This control adds range slider to the Customizer which allows
 * you to choose number from a range slider.
 *
 * Radio Buttonset is a part of O2 library, which is a
 * free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this library. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package O2 Customizer Library
 * @subpackage Range Slider
 * @since 0.1
 */
if ( ! function_exists( 'o2_add_range_slider_control' ) ) :

	function o2_add_range_slider_control( $wp_customize ) {
		class O2_Customizer_Range_Slider_Control extends WP_Customize_Control {

			public $type = 'o2-range-slider';

			public function to_json() {
				if ( ! empty( $this->setting->default ) ) {
					$this->json['default'] = $this->setting->default;
				} else {
					$this->json['default'] = false;
				}
				if ( ! empty( $this->input_attrs ) ) {
					$this->json['max'] = $this->input_attrs['max'];
					$this->json['min'] = $this->input_attrs['min'];
				} else {
					$this->json['max'] = 1000;
					$this->json['min'] = 0;
				}
				if ( isset( $this->choices['percent'] ) ) {
					$this->json['percent'] = $this->choices['percent'];
				} else {
					$this->json['percent'] = false;
				}
				parent::to_json();
			}

			public function enqueue() {
				wp_enqueue_script( 'o2-range-slider', LOGINCUST_FREE_URL . 'inc/customizer/controls/range-slider/assets/js/range-slider-control.js', array( 'jquery' ), '', true );
				wp_enqueue_style( 'o2-range-slider', LOGINCUST_FREE_URL . 'inc/customizer/controls/range-slider/assets/css/range-slider-control.css' );
			}

			public function render_content() {
				?>
				<div>
					<?php if ( ! empty( $this->label ) ) : ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?>
						<?php if ( isset( $this->choices['percent'] ) && ( $this->choices['percent'] !== false ) ) : ?>
							<div class="button-group" data-setting="align">
								<input type="radio" class="o2-range-slider-buttonset" id="px-<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="px" />
								<label class="button" for="px-<?php echo esc_attr( $this->id ); ?>"><?php _e( 'px', 'login-customizer' ); ?></label>
								<input type="radio" class="o2-range-slider-buttonset" id="percent-<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="%" />
								<label class="button" for="percent-<?php echo esc_attr( $this->id ); ?>"><?php _e( '%', 'login-customizer' ); ?></label>
							</div>
						<?php endif; ?>
						</span>
						<?php
					endif;
if ( ! empty( $this->description ) ) :
	?>
						<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
					<?php endif; ?>
					<div id="<?php echo esc_attr( $this->id ); ?>">
						<div class="o2-range-slider">
							<input class="o2-range-slider-range" type="range" value="<?php echo intval( $this->value() ); ?>" <?php $this->input_attrs(); ?> />
							<input class="o2-range-slider-value" type="number" value="<?php echo intval( $this->value() ); ?>" <?php $this->input_attrs(); ?> />
							<?php if ( ! empty( $this->setting->default ) ) : ?>
								<span class="o2-range-reset-slider" title="<?php _e( 'Reset', 'login-customizer' ); ?>"><span class="dashicons dashicons-image-rotate"></span></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php
			}

		}
	}
	add_action( 'customize_register', 'o2_add_range_slider_control' );

endif;
