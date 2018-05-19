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
	// Get POST request as JSON
	$data = json_decode(file_get_contents('php://input'), true);

	// Get the form fields and remove whitespace.
	$email = filter_var(trim($data["email"]), FILTER_SANITIZE_EMAIL);
	$recipient = filter_var(trim($data["recipient"]), FILTER_SANITIZE_EMAIL);
	$subject = trim($data["subject"]);
	$message = trim($data["message"]);

	try {
		$mg->messages()->send(getenv('MAILGUN_DOMAIN'), [
			'from'    => $email,
			'to'      => $recipient,
			'subject' => $subject,
			'text'    => $message
		]);
	} catch (Exception $e) {
		http_response_code(500);
		exit;
	}

	// Set a 200 (okay) response code.
	http_response_code(200);
	echo $email;
	echo $recipient;
	echo $subject;
	echo $message;
	exit;

} else {
	// Not a POST request, set a 403 (forbidden) response code.
	http_response_code(403);
}
