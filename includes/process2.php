<?php

$required = ['name', 'email', 'phonenumber'];

// Check $_POST Array
foreach ($_POST as $key => $value) {
	if (in_array($key, $required)) {
		if (!is_array($value)) {
			$value = trim($value);
		}
		if (empty($value) && in_array($key, $required)) {
			$$key = '';
			$missing[] = $key;
		} else {
			$$key = $value;
		}
	}
} 

// Check email address
if (!in_array($email, $missing)) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors['email'] = 'Please use a valid email address';
    }
}

// process only if there are no errors or missing fields
if (!$errors && !$missing) {
	require_once __DIR__ . '/config.php';
	
//set up replacements for decorator plugin
$replacements = [
    "ma301co@gold.ac.uk" =>
        ['#subject#' => 'Confirmation of Goldsmiths Bootcamp Registration',
         '#name#' => "$name",
         '#message#' => "Hello",]
];

	try {
		
	$transport = Swift_SmtpTransport::newInstance($smtp_server, 587, 'tls')
    ->setUsername($username)
    ->setPassword($password);
	$mailer = Swift_Mailer::newInstance($transport);

	// register the decorator and replacements
	$decorator = new Swift_Plugins_DecoratorPlugin($replacements);
	$mailer->registerPlugin($decorator);

	// initialize the message
     $message = Swift_Message::newInstance()
    ->setSubject('#subject#')
    ->setFrom($from);
	
	// set the HTML body
	$message->setBody('#message#',"text/html");
	
	// initialize emails to track the emails
	$sent = 0;
	$failures = [];
	
	// send the message 
	foreach ($replacements as $recipient => $values) {
		$message->setTo($recipient);
		$sent += $mailer->send($message, $failures);
		
	}
	
	//if messages has been sent, redirect to relevant page
	if ($sent == 1) {
	    header('Location: thanks.php');
	    exit;
	}
	
	// handle failures
	$num_failed = count($failures);
	if ($num_failed == 2) {
	    $f = 'both';
	} elseif ($num_failed == 1 && in_array($email, $failures)) {
	    $f = 'email';
	} else {
	    $f = 'reg';
	}

	} catch(exception $e) {
		echo $e->getMessage();
	}

}
?>