<?php
    require 'vendor/autoload.php';
    require_once 'helpers/Common.php';
    require_once 'helpers/captcha.php';
    
    function doError($msg, $status = 'error') {
        saveFlashMessage($status, $msg);
        redirect('index.php', 'location', 302);
        exit;
    }

    if (filter_input_array(INPUT_POST)) {
        $response = $captcha->check();

        if (!$response->isValid()) {
            doError('Invalid captcha');
        } else {
            if (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $toEmail = 'a.wyett@tocc.co.uk';
                $mailSubject = 'Buy Domain Request';
                $mailHeader = "From: The Website (" . filter_input(INPUT_SERVER, 'SERVER_NAME') . ")\r\n";
                $mailHeader .= "Reply-To: ".filter_input(INPUT_POST, 'email')."\r\n";
                $mailHeader .= "Content-type: text/html; charset=iso-8859-1\r\n";
                
                $mailBody = '';
                $fields = array('name', 'email', 'phone', 'domain', 'message');
                foreach ($fields as $field) {
                    
                    if (!filter_input(INPUT_POST, $field)
                        || filter_input(INPUT_POST, $field) == ''
                    ) {
                        doError('Please enter your ' . $field);
                    }
                    
                    $mailBody .= sprintf(
                        '<p>%s: %s</p>',
                        ucfirst($field),
                        filter_input(INPUT_POST, $field)
                    );
                }

                if (mail($toEmail, $mailSubject, $mailBody, $mailHeader)) {
                    doError('Thank you, your email has been sent.  We will be in touch shortly!', 'success');
                } else {
                    doError('Sorry, there was a problem sending your email.  Please try again.', 'error');
                }
            } else {
                doError('Invalid email address', 'error');
            }
        }
    } else {
        doError('Invalid email address', 'error');
    }