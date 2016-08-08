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
	
	// set up replacements for decorator plugin
$replacements = [
    $email =>
        ['#subject#' => 'Confirmation of Goldsmiths Bootcamp Registration',
         '#name#' => "$name"],
    'ma301@gold.ac.uk' =>
        ['#subject#' => "Goldsmiths Bootcamp Registration for $name",
         '#greeting#' => "Registration details for $name.",
         '#phonenumber#' => 'Registration phone number $phonenumber']
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
	
	// embed image
	$image = $message->embed(Swift_Image::fromPath('img/logo_medium.png'));
	
$html = <<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Goldsmiths Bootcamp</title>
		<style type="text/css">
		
			@media only screen and (min-width: 1024px) {
				table.container { width: 640px !important; }
				td.email_logo img { width: 100%; }
				
			}
			
		</style>
	</head>	
	<body bgcolor="#efe1b0">

		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#efe1b0">
			<tr>
				<td>
					<table class="container" width="440" align="center" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td valign="top" class="email_logo">
							<img src="$image" alt="Goldsmiths Bootcamp" class="test" border="0"/>	
							</td>
						</tr>
						<tr>
							<td valign="top" class="headline" bgcolor="#ffffff" style="padding: 15px 20px 5px 30px; 
							border-left: 1px solid #dbc064; border-right: 1px solid #dbc064; font-family: Arial, 
							Helvetica, sans-serif; font-size: 16px; line-height: 30px;">
							<h1 style="margin: 0px 0px 15px 0px; font-weight: normal; font-size: 32px;
							color: #bd9c61; text-align: center;">Welcome to Goldsmiths Bootcamp</h1>	
							</td>
						</tr>
						<tr>
							<td valign="top" class="content" style="padding: 30px 30px 
							10px 30px; border-right: 1px solid #dbc064; border-left: 1px solid #dbc064; 
							font-family:Arial, Helvetica, sans-serif; font-size: 16px; line-height:22px; 
							color: #654308;">
							Hi #name# I want to take this opportunity to welcome you to the Goldsmiths Bootcamp.
							<br><br>
							My name is Conor Okus and I am your main trainer, instructor and contact. 
							I would like to give you some general information about our Bootcamp and how it 
							can help you achieve your health and fitness goals.
							<br><br>
							Our Bootcamps are a great way of improving your all round physique because it typically involves 
							routines and workouts that work almost all body parts. From running, jumping and skipping to pushing, 
							pulling and twisting Bootcamps provide it all.
							<br><br>
							You can expect to;
							<ul>
								<li>Lose weight, ditch excess body fat and tone up your body</li>
								<li>Quickly drop 1-2 cloth sizes and feel confident and comfortable in your clothes</li>
								<li>Enjoy fun, innovative 30-45 minute exercise programs</li>
								<li>Use scientifically proven workout techniques and programs to melt away fat</li>
							</ul>
							Goldsmiths Bootcamp is a fun and energetic fitness workout program that includes, motivation, 
							accountability and dynamic resistance training all designed to get you the body that you want in a safe, 
							fun and non-intimidating atmosphere. It has been proven that people are more likely to reach their fitness
						    goals in a group environment so you will have plenty of support and help from everyone in the group. 
						    <br /><br />
						    Classes: Wednesday 5pm-6pm, Goldsmiths University in the “Stretch”
						    <br /><br />
							Annual Membership: £25
							<br /><br />
							Enjoy your training and once again – welcome to our Bootcamp!
							<br /><br />
							Kind Regards,
							<br><br />
							COkus
								
							</td>
						</tr>
						<tr>
							<td valign="top" class="footer" bgcolor="#000000" style="padding: 15px 20px 5px 30px; 
							border-left: 1px solid #dbc064; border-right: 1px solid #dbc064; font-family: Arial, 
							Helvetica, sans-serif; font-size: 16px; line-height: 22px; color: white;">
							&copy; Goldsmiths Bootcamp. PLEASE DO NOT REPLY TO THIS MESSAGE:
							<br><br>
							Your <a href="#" style="color:#bd9c61;;">privacy</a> is important to us. Please use this link to <a href="#" style="color:#bd9c61;;">unsubscribe</a>.
							<br><br>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
		</table>

	</body>	
</html>


EOT;
	
	// set the HTML body
	$message->setBody($html,"text/html");
	
	// initialize emails to track the emails
	$sent = 0;
	$failures = [];
	
	// send the message 
	foreach ($replacements as $recipient => $values) {
		$message->setTo($recipient);
		$sent += $mailer->send($message, $failures);
	}
	
	//if both messages have been sent, redirect to relevant page
	if ($sent == 2) {
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
