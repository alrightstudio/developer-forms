<?php

// Include Mailgun
require 'vendor/autoload.php';
use Mailgun\Mailgun;
$mg = Mailgun::create(getenv('MAILGUN_API_KEY'));

// Allow CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Origin: *');

// Respond to Preflights
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	http_response_code(204);
	exit;
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the form fields and remove whitespace.
	$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
	$recipient = filter_var(trim($_POST["recipient"]), FILTER_SANITIZE_EMAIL);
	$subject = trim($_POST["subject"]);
	$message = trim($_POST["message"]);

	try {
		$mg->messages()->send(getenv('MAILGUN_DOMAIN'), [
			'from'    => $email,
			'to'      => $recipient,
			'subject' => $subject,
			'text'    => $message
		]);
	} catch (Exception $e) {
		// Set a 500 (internal server error) response code.
		http_response_code(500);

		echo 'Caught exception: ',  $e->getMessage(), "\n";
		echo($email);
		echo($recipient);
		echo($subject);
		echo($message);
	}

	// Set a 200 (okay) response code.
	http_response_code(200);
	echo "Thank You! Your message has been sent.";

} else {
	// Not a POST request, set a 403 (forbidden) response code.
	http_response_code(403);
	echo "There was a problem with your submission, please try again.";
}
