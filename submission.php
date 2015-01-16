<?php
    require 'vendor/autoload.php';
    $captcha = new Captcha\Captcha();
    $captcha->setPublicKey('6LfQFwATAAAAAL1NsiJvKCl6K7e9p8qr600syhpM');
    $captcha->setPrivateKey('6LfQFwATAAAAAAwYTafRuuPTN91--B6L7S97PTdq');

    if (!empty($_POST)) {
        $response = $captcha->check();

        if (!$response->isValid()) {
            echo $response->getError();
        } 
    }
 
    if (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $toEmail = 'b.hall@tabs-software.co.uk';
        $mailSubject = 'Buy Domain Request';
        $mailHeader = "From: ".$_POST['email']."\r\n";
        $mailHeader .= "Reply-To: ".$_POST['email']."\r\n";
        $mailHeader .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $mailBody = "Name: ".$_POST['name']."<br>";
        $mailBody .= "Email: ".$_POST['email']."<br>";
        $mailBody .= "phone: ".$_POST['phone']."<br>";
        $mailBody .= "domain: ".$_POST['domain']."<br>";
        $mailBody .= "Comment: ".$_POST['message'];
        
        if (mail($toEmail, $mailSubject, $mailBody, $mailHeader)) {
            print "Email Sent";
        }      
    }
?>
