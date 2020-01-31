<?php

$to = 'emailsendto@example.com';
$subject = 'The subject';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name &lt;support@example.com');
 
wp_mail( $to, $subject, $body, $headers );

add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);
function log_mailer_errors( $wp_error ){
  $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
  $fp = fopen($fn, 'a');
  fputs($fp, "Mailer Error: " . $wp_error->get_error_message() ."\n");
  fclose($fp);
}


// assumes $to, $subject, $message have already been defined earlier...
 
$headers[] = 'From: Me Myself <me@example.net>';
$headers[] = 'Cc: John Q Codex <jqc@wordpress.org>';
$headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address
 
wp_mail( $to, $subject, $message, $headers );

$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: Wishio Team ' . "\r\n";

wp_mail( $to, $subject, $message, $headers);

$name = "Site name";
$email = "info@sitename.com";
if(isset $_POST["name"]){
$name = sanitize_text_field($_POST["name"]);
$email = sanitize_email($_POST["email"]);

$multiple_recipients = array(
    'recipient1@example.com',
    'recipient2@foo.example.com'
);
$subj = 'The email subject';
$body = 'This is the body of the email';
wp_mail( $multiple_recipients, $subj, $body );


?>