<?php
//require("libs/class.phpmailer.php");
/**
 * Theme My Login Compatibility Functions
 *
 * Note I proposed a patch that, if accepted, would negate the need for this file.
 * @link https://core.trac.wordpress.org/ticket/31039
 *
 * @package Theme_My_Login
 * @subpackage Compatibility
 */

/**
 * Handles validating the lost password request and retrieving the password reset key.
 *
 * @since 7.0
 *
 * @return True on success, WP_Error on error.
 */
function tml_retrieve_password() {
	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) || ! is_string( $_POST['user_login'] ) ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or email address.' ) );
	} elseif ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
		if ( empty( $user_data ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) );
		}
	} else {
		$login     = trim( $_POST['user_login'] );
		$user_data = get_user_by( 'login', $login );
	}

	/** This action is documented in wp-login.php */
	do_action( 'lostpassword_post', $errors );

	if ( $errors->get_error_code() ) {
		return $errors;
	}

	if ( ! $user_data ) {
		$errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) );
		return $errors;
	}

	$key = get_password_reset_key( $user_data );
	if ( is_wp_error( $key ) ) {
		return $key;
	}

	/**
	 * Fires after a password reset key is retrieved.
	 *
	 * @since unknown
	 *
	 * @param WP_User $user_data The user object.
	 * @param string  $key       The password reset key.
	 */
	do_action( 'retrieved_password_key', $user_data, $key );

	return true;
}

/**
 * Sends the retrieve password notification.
 *
 * @since 7.0
 *
 * @param WP_User $user The user object.
 * @param string $key   The password reset key.
 */
function tml_retrieve_password_notification( $user, $key ) {
	if ( is_multisite() ) {
		$site_name = get_network()->site_name;
	} else {
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
	$message = ('<div class="mailheader text-center" style="height: 124px;width: 600px;border: 1px solid #979797;background-color: #002F6C;">
			<img style="margin-top:35px;text-align:center;" src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/rebow-logo-white.svg">
		</div>

		<div class="mailcontent" style="width: 600px;">
			<h5 class="text-center" style="margin-top:30px;text-align:center;font-family: "axiformabook";letter-spacing: 1px;color: #005592;font-size: 1.25rem;">Account Activation</h5>');
	$message .= __( '<p class="mailtext" style="padding:20px;font-family: Axiforma;font-size: 14px;letter-spacing:1.17px;line-height: 21px;"> Hi ' ).sprintf( __( 'Username: %s' ), $user->user_login );
	/* translators: %s: site name */
	//$message .= sprintf( __( 'Site Name: %s' ), $site_name ) . "\r\n\r\n";
	/* translators: %s: user login */
	//$message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
	$message .= __( '<br/>Per your request, please click the link below to reset your ReBow account password :' ) . "\r\n\r\n";
	//$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
	$message .= '' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . "\r\n";

	//$message .=__( '<br/>If this email was received in error, please ignore.' );

	$message .=__( '<br/>If you have trouble logging in, or accessing your account. 
Please call us at 323.277.1111 or email us at info@rebowsystem.com' );

	$message .=__( '<br/>If this email was received in error, please ignore. </p></div>' );
	///echo "Message".$message;
	/* translators: Password reset email subject. %s: Site name */
	$message .= __('<div class="mailfooter">
			<div class="mailfooter1" style="height: 15px;width: 600px;transform: scaleY(-1);background-color: #B2D235;"></div>
			<div class="mailfooter2" style="height: 194px;width: 600px;background-color: #002F6C;">
				<div class="footer-text text-center" style="color: #BBBBBB;font-family: Axiforma;font-size: 8px;font-weight: 600;letter-spacing: 0.67px;line-height: 11px;text-align: center;padding-top:30px;">MAILING ADDRESS :
					<br/><br/>141 W Avenue 34,
					<br/>Los Angeles, CA 90031
					<br/>info@rebowsystem.com     •      323 - 277 - 1111
				</div>
				<br/>
				<div class="row">
					<div class="col-sm-3 col-md-3"></div>
					<div class="col-sm-6 col-md-6">
			          
			          	<div class="row">
				            <div class="col-md-3">
				              <a href="javascript:;">
				              	<img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/g-plus.svg">
				              </a>
				            </div>
				            <div class="col-md-3">
				              <a href="https://twitter.com/rebowsystem">
				                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/twiter.svg">
				              </a>
				            </div>
				            <div class="col-md-3">
				              <a href="https://www.facebook.com/ReBowSystem/">
				                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/fb.svg">
				              </a>
				            </div>
				            <div class="col-md-3">
				              <a href="https://twitter.com/rebowsystem">
				                <img src="/rebow/wp-content/themes/di-ecommerce-child/assets/images/insta.svg">
				              </a>
				            </div>
			        	</div>
			          
			        </div>
			        <div class="col-sm-3 col-md-3"></div>
		      	</div>
		    	
        <div class="footer-text" style="color: #BBBBBB;font-family: Axiforma;font-size: 8px;font-weight: 600;letter-spacing: 0.67px;line-height: 11px;text-align: center;padding-top:30px;">COPYRIGHT © 2019 REBOW SYSTEMS.</div>
			</div>
		</div>');
	$title = sprintf( __( '[%s] Password Reset' ), $site_name );

	/**
	 * Filters the subject of the password reset email.
	 *
	 * @since 2.8.0
	 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
	 *
	 * @param string  $title      Default email title.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user       WP_User object.
	 */
	$title = apply_filters( 'retrieve_password_title', $title, $user->user_login, $user );

	/**
	 * Filters the message body of the password reset mail.
	 *
	 * If the filtered message is empty, the password reset email will not be sent.
	 *
	 * @since 2.8.0
	 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
	 *
	 * @param string  $message    Default mail message.
	 * @param string  $key        The activation key.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user       WP_User object.
	 */
	$message = apply_filters( 'retrieve_password_message', $message, $key, $user->user_login, $user );

	$retrieve_password_email = array(
		'to'      => $user->user_email,
		'subject' => $title,
		'message' => $message,
		'headers' => '',
	);

	/**
	 * Filters the contents of the password retrieval email.
	 *
	 * @since 7.0.6
	 *
	 * @param array   $retrieve_password_email {
	 *     Used to build wp_mail().
	 *
	 *     @type string $to      The recipient of the email.
	 *     @type string $subject The subject of the email.
	 *     @type string $message The body of the email.
	 *     @type string $headers The headers of the email.
	 * }
	 * @param WP_User $user      The user object..
	 * @param string  $site_name The site title.
	 */
	$retrieve_password_email = apply_filters( 'tml_retrieve_password_email', $retrieve_password_email, $user, $site_name );

	if ( $retrieve_password_email['message'] && ! wp_mail(
		$retrieve_password_email['to'],
		wp_specialchars_decode( sprintf( $retrieve_password_email['subject'], $site_name ) ),
		$retrieve_password_email['message'],
		$retrieve_password_email['headers']
	) ) {
		wp_die( __( 'The email could not be sent.' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.' ) );
	}
	/*if(empty($retrieve_password_email['to'])){
		$retrieve_password_email['to']=array("patilyogesh1000@gmail.com");
	}*/
	/*if ( $retrieve_password_email['message'] && ! shootmail(
		$retrieve_password_email['to'],wp_specialchars_decode($retrieve_password_email['subject']),wp_specialchars_decode($retrieve_password_email['message'])
	) ) {
		wp_die( __( 'The email could not be sent.' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.' ) );
	}*/
}
function shootmail($to_email,$subject,$body){

		$mail = new PHPMailer();
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		//$mail->Username   = "patilyogesh1000@gmail.com";  // GMAIL username
		
		//$mail->Password   = "Patanikasu123!";            // GMAIL password


		//$mail->AddAttachment($attachment);
		//$mail->AddAttachment($attachment2);
		//$mail->AddStringAttachment($attachment, "output.csv");
		$mail->SetFrom('patilyogesh1000@gmail.com','Mail Alert');
		$mail->IsHTML(true);
        
		$mail->Subject = $subject;

		$mail->MsgHTML($body);

		
		/*foreach ($to_email as $to_emails){
			$address =  $to_emails; 
			$mail->AddAddress($address, $to_emails);
		}*/

		$mail->AddAddress($to_email, $to_email);
		//$mail->AddAddress($address, $to_emails);
		//echo '<pre>';
		//print_r($mail->Send());

		if(!$mail->Send()) {
			//print_r($mail);
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			//print_r($mail);
			echo "Message sent!";
		}
	}
