<?php

// Include Mailgun
require 'vendor/autoload.php';
use Mailgun\Mailgun;
$mg = Mailgun::create(getenv('MAILGUN_API_KEY'));

// Allow CORS
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: *');
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
	$from = filter_var(trim($data["from"]), FILTER_SANITIZE_EMAIL);
	$to = filter_var(trim($data["to"]), FILTER_SANITIZE_EMAIL);
	$subject = trim($data["subject"]);
	$html = trim($data["html"]);
	$text = trim($data["text"]);

	$email = [
		'from'    => $from,
		'to'      => $to,
		'subject' => $subject,
		'html'    => $html,
		'text'    => $text
	];

	try {
		$mg->messages()->send(getenv('MAILGUN_DOMAIN'), $email);
	} catch (Exception $e) {
		http_response_code(500);
		echo json_encode([
			'error' => 'There was an error sending this email.'
		]);
		exit;
	}

	// Set a 200 (okay) response code.
	http_response_code(200);
	echo json_encode($email);
	exit;

} else {
	// Not a POST request, set a 403 (forbidden) response code.
	http_response_code(403);
	echo json_encode([
		'error' => 'Malformed request. Please send a JSON POST request with mail data in the body.'
	]);
}
