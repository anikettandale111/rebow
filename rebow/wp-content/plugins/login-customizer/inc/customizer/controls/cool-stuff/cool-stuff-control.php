<?php
// Sendinblue Subscription Box

if ( ! function_exists( 'logincust_more_cool_stuff_control' ) ) :

	function logincust_more_cool_stuff_control( $wp_customize ) {
		class Logincust_Cool_Stuff_Control extends WP_Customize_Control {

			public function enqueue() {
				wp_enqueue_style( 'logincust-cool', LOGINCUST_FREE_URL . 'inc/customizer/controls/cool-stuff/assets/css/cool-stuff-control.css' );
			}

			public function render_content() {
				if ( ! empty( $_POST['logincust_mail'] ) ) {
					$was_submited = get_option( 'logincust_mail_was_submited', false );
					$user_info = get_userdata( 1 );
					$mailin = new Mailin( 'https://api.sendinblue.com/v2.0', 'cHW5sxZnzE7mhaYb' );
					$data = array(
						'email' => $_POST['logincust_mail'],
						'attributes' => array('NAME' => $user_info->first_name, 'SURNAME' => $user_info->last_name),
						'blacklisted' => 0,
						'listid' => array(34),
						'blacklisted_sms' => 0,
					);
					$status = $mailin->create_update_user( $data );
					if ( $status['code'] == 'success' ) {
						if ( empty( $was_submited ) ) {
							add_option( 'logincust_mail_was_submited', true );
						}
					}
				}
				$was_submited = get_option( 'logincust_mail_was_submited', false );
				if ( $was_submited === false ) {
					echo sprintf(
						'<form class="logincust-submit-mail" method="post"><p> %s </p><input name="logincust_mail" type="email" class="wp-pointer-input" value="' . get_option( 'admin_email' ) . '" /><input class="button wp-pointer-submit" type="submit" value="Submit"></form>',
						esc_html__( 'Our free, 4-lesson course on how to make your WordPress site run incredibly fast is barely waiting for its students. Ready to learn how to reduce your loading times by half? Come and join the 1st lesson here!', 'login-customizer' )
					);
				} else {
					echo sprintf(
						'<p class="logincust-submit-mail">%s</p>',
						esc_html__( 'Thank you for subscribing! You have been added to the mailing list and will receive the next email information in the coming weeks. If you ever wish to unsubscribe, simply use the Unsubscribe link included in each newsletter.', 'login-customizer' )
					);
				}
				echo '<a href="https://themeisle.com/plugins/orbit-fox-companion/" target="_blank"><img src="' . LOGINCUST_FREE_URL . 'assets/orbit-fox.png" /></a>';
			}

		}
	}
	add_action( 'customize_register', 'logincust_more_cool_stuff_control' );

endif;
