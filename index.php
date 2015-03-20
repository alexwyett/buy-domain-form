<?php 

require 'vendor/autoload.php';
require_once 'helpers/Common.php';
require_once 'helpers/captcha.php';

$domain = parse_url(filter_input(INPUT_SERVER, 'SERVER_NAME'));

if (!$domain || (is_array($domain) && !isset($domain['path']))) {
    header("HTTP/1.0 404 Not Found");
    die();
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $domain['path']; ?> | Would you like to buy this domain?</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" type="text/css" media="all" />
    </head>
    <body>

        <h1><?php print $domain['path']; ?> </h1>
        <p>Want to buy this domain?</p>
        
        <?php
            echo getFlashStatusMessage();
        ?>

        <form method="post" action="submission.php" class="enquiry-form">
	    <fieldset name="Enquiry Form">
            <label for="name" hidden>Name</label>
		<input type="text" class="form-input" name="name" id="name" placeholder="Name:">
            <label for="email" hidden>Email</label>
		<input type="text" class="form-input" name="email" id="email" placeholder="Email:">
	    <label for="phone" hidden>Phone</label>
            	<input type="text" class="form-input" name="phone" id="phone" placeholder="Phone:">
	    <?php print "<input type='hidden' name='domain' value='".$domain['path'] ."'>"?>
            <label for="message" hidden>Message</label>
            	<textarea name="message" class="form-input" name="message" id="message" placeholder="Message:"></textarea>
		<?php echo $captcha->html(); ?>
	    <label for="enquire_now" hidden>Enquire Now</label>
            	<input type="submit" class="form-input" value="Enquire Now" id="enquire_now">
	    </fieldset>
        </form>
    </body>
</html>
