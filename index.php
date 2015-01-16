<?php 

require 'vendor/autoload.php';
$captcha = new Captcha\Captcha();
$captcha->setPublicKey('6LfQFwATAAAAAL1NsiJvKCl6K7e9p8qr600syhpM');
$captcha->setPrivateKey('6LfQFwATAAAAAAwYTafRuuPTN91--B6L7S97PTdq');

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php print "<title>" . $_SERVER["SERVER_NAME"] . "</title>"; ?>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" type="text/css" media="all" />
    </head>
    <body>

        <h1><?php print $_SERVER["SERVER_NAME"]; ?> </h1>
        <p id="buy_domain">Want to buy this domain?</p>

        <form method="post" action="submission.php">
	    <fieldset name="Enquiry Form">
            <label for="name" hidden>Name</label>
		<input type="text" class="form-input" name="name" id="name" placeholder="Name:">
            <label for="email" hidden>Email</label>
		<input type="text" class="form-input" name="email" id="email" placeholder="Email:">
	    <label for="phone" hidden>Phone</label>
            	<input type="text" class="form-input" name="phone" id="phone" placeholder="Phone:">
	    <?php print "<input type='hidden' name='domain' value='".$_SERVER['SERVER_NAME'] ."'>"?>
            <label for="message" hidden>Message</label>
            	<textarea name="message" class="form-input" name="message" id="message" placeholder="Message:"></textarea>
		<?php echo $captcha->html(); ?>
	    <label for="enquire_now" hidden>Enquire Now</label>
            	<input type="submit" class="form-input" value="Enquire Now" id="enquire_now">
	    </fieldset>
        </form>
    </body>
</html>
