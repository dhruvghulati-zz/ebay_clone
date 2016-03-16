<?php

date_default_timezone_set('Etc/UTC');

require 'PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail -> isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail -> SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail -> Debugoutput = 'html';

//Set the hostname of the mail server
$mail -> Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail -> Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail -> SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail -> SMTPAuth = true;

//Username to use for SMTP authentication
$mail -> Username = "databaseucl@gmail.com";

//Password to use for SMTP authentication
$mail -> Password = "databases";

//Set who the message is to be sent from
$mail -> setFrom('databaseucl@gmail.com', 'UCL Database');

