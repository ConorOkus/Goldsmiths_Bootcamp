<?php
/*
 * $loader needs to be a relative path to an autoloader script.
 * Swift Mailer's autoloader is swift_required.php in the lib directory.
 * If you used Composer to install Swift Mailer, use vendor/autoload.php.
 */
$loader = __DIR__ . '/../swiftmailer/lib/swift_required.php';

require_once $loader;

/*
 * Login details for mail server
 */
$smtp_server = 'smtp.office365.com';
$username = 'cokus049@campus.goldsmiths.ac.uk';
$password = 'Dagger$1';

/*
 * Email addresses for testing
 * The first two are associative arrays in the format
 * ['email_address' => 'name']. The rest contain just
 * an email address as a string.
 */
$from = ['ma301co@gold.ac.uk' => 'Conor'];
$test1 = ['conorokus91@gmail.com' => 'Test'];
$testing = '';
$test2 = '';
$test3 = '';
$secret = '';
$private = '';
