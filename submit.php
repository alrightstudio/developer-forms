<?php
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
		$name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
		$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
		$recipient = filter_var(trim($_POST["recipient"]), FILTER_SANITIZE_EMAIL);
		$message = trim($_POST["message"]);

		// Check that data was sent to the mailer.
		if (
			empty($name) OR
			empty($message) OR
			!filter_var($email, FILTER_VALIDATE_EMAIL) OR
			!filter_var($recipient, FILTER_VALIDATE_EMAIL)
		) {
			// Set a 400 (bad request) response code and exit.
			http_response_code(400);
			echo "Oops! There was a problem with your submission. Please complete the form and try again.";
			exit;
		}

		// Set the email subject.
		$subject = "New contact from $name";

		// Build the email content.
		$content = "Name: $name\n";
		$content .= "Email: $email\n\n";
		$content .= "Message:\n$message\n";

		// Build the email headers.
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: $name <$email>";

		// Send the email.
		if (mail($recipient, $subject, $content, $headers)) {
			// Set a 200 (okay) response code.
			http_response_code(200);
			echo "Thank You! Your message has been sent.";
		} else {
			// Set a 500 (internal server error) response code.
			http_response_code(500);
			echo "Oops! Something went wrong and we couldn't send your message.";
		}

	} else {
		// Not a POST request, set a 403 (forbidden) response code.
		http_response_code(403);
		echo "There was a problem with your submission, please try again.";
	}

?>