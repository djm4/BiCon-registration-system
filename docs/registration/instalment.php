<?php

require_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

if (!$logged_in) {
  header("Location: $http_host/registration/index.php");
}

include( 'reg/charges.inc' );

include( 'reg/payment.inc' );

include( "reg/header.inc" );

$amount = $_POST[ 'instalment' ];
$floatamount = $amount;
$id = $_POST[ 'id' ];
$totalremain = $_POST[ 'totalremain' ];

$currency = $logged_in_person->getCurrency();
$currency_code = $logged_in_person->getCurrencyCode();

settype( $amount , 'integer' );
settype( $id , 'integer' );
settype( $totalremain , 'integer' );

$paypaltot = $amount;

if ( $amount <= 0 ) {

    echo ("<h2>Payment error</h2>");
    echo( "<p>The amount that you wish to pay ($amount) must be greater than zero. Please press the <strong>back</strong> button and try again.</p>" );

} elseif ( $amount > $totalremain ) {

    echo ("<h2>Payment error</h2>");
    echo( "<p>The amount to be paid ($amount) is greater than the total remaining to complete your booking ($totalremain). Please press the <strong>back</strong> button and try again.</p>" );

} elseif ( $id == 0 ) {

    echo ("<h2>Payment error</h2>");
    echo( "<p>That id ($id) isn't valid.</p>" );

} elseif ( $amount != $floatamount ) {

    echo ("<h2>Payment error</h2>");
    echo( "<p>Sorry, we can only process whole number payments (aside from the Paypal fee contribution). Please press the <strong>back</strong> button and try again.</p>" );
   
} else {

    echo( "

<h2>Pay by instalment</h2>

<p>
The button below will bring you to the paypal website, where
you will be charged 

<font color='#ff0000'><strong>$currency$paypaltot</strong></font>.
</p>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<p>
Pay  
<font color='#ff0000'><strong>$currency$paypaltot</strong></font>
to BiCon 2010 (paypal:paypal@bicon2010.org.uk)
<input type='hidden' name='notify_url' value='https://secure.10icb.org/registration/paypal-ipn.php'>
<input type='hidden' name='return' value='https://secure.10icb.org/registration/'>
<input type='hidden' name='image_url' value='https://secure.10icb.org/bicon/logo.jpg'>
<input type='hidden' name='custom' value='$logged_in_person->id'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='paypal@bicon2010.org.uk'>
<input type='hidden' name='item_name' value='Bicon Registration'>
<input type='hidden' name='item_number' value='instalment:id:$logged_in_person->id'>
<input type='hidden' name='amount' value='$paypaltot'>
<input type='hidden' name='no_shipping' value='2'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='currency_code' value='$currency_code'>
<input type='hidden' name='lc' value='GB'>
<input type='hidden' name='bn' value='PP-BuyNowBF'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/x-click-but23.gif' border='0' name='submit' alt='Make paymen
ts with PayPal - it's fast, free and secure!'>
<img alt='' border='0' src='https://www.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>
</p>
</form>

");

}

	include( "reg/footer.inc" );

?>


