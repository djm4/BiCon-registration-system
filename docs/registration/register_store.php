<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

include( 'reg/payment.inc' );
include( 'reg/randompasswd.inc' );
$logfilename = "$logfilepath/reg.log";

$person = new BiConAttendee();
if ($logged_in) {
	$person = $logged_in_person;
}

$form = $_POST;
$person->readForm($form);
if ($person->passwd == '') {
	$person->generatePassword();
}

$person->save();
if (!$logged_in) {
	$session->create($person);
	$session->createCookie(true, true);
	$logged_in = true;
	$logged_in_person = $person;
}

$bireconcharges = new BiReConCharges();
$biconcharges = new BiConCharges();

$total = $person->calculateCharge($biconcharges, $bireconcharges);

{
	$mailto = $person->email;
	$mailsubj = "Your BiCon 2010 booking details - $person->id";
	$mailheaders = "From: BiCon 2010 Bookings Robot <booking-bounces@reg.bicon2010.org.uk>
X-Mailer: BiCon 2010 Registration System v1
X-Bicon: BiCon 2010 booking
X-Booking-ID: $person->id";

	$message = "Thank you for booking for $event_longer!

Your booking id is " . $person->id . " and your password is: " . $person->passwd . "

Please hold on to this information as you will require it to pay for
your booking, and to review it on the website. You may, at any time,
review your booking details at this address:

https://secure.10icb.org/registration/

If you have any problems, please give our webmaster a shout -
webmaster@bicon2010.org.uk.

Thanks again, and see you in Docklands!

The BiCon 2010 Registration Robot.";

	$mailed = mail( $mailto , $mailsubj , $message , $mailheaders , '-f"booking-bounces@reg.bicon2010.org.uk"' );
	
	$mailheaders = "From: Bicon 2010 Bookings Duplicate <booking-bounces@reg.bicon2010.org.uk>
X-Mailer: BiCon 2010 Registration System v1
X-Bicon: Backup copy of BiCon 2010 booking information
X-Booking-ID: $person->id";

  $bakmailed = mail( "reg-robot@bicon2010.org.uk" , "BiCon 2010 booking $person->id" , print_r($person, true) , $mailheaders , '-f"booking-bounces@reg.bicon2010.org.uk"' );

	if ( !$logfile = fopen( $logfilename, "a" ) ) {
			header( "HTTP/1.0 500 Server error" );
			echo( "Server error, can't open logfile" );
			exit;
	}

	fwrite( $logfile , "mailed " . $mailed . " bak " . $bakmailed . "\n\r" );

}

$displayfirstname = $person->firstname;
$displaysurname = $person->surname;
$displayemail = $person->email;
$currency = $person->getCurrency();
$currency_code = $person->getCurrencyCode();

$parkingspace = $person->parkingspace;
$flatpref = $person->flatpref;

$addr1 = $person->addr1;
$addr2 = $person->addr2;
$addr3 = $person->addr3;
$town = $person->town;
$county = $person->county;
$country = $person->country;
$postcode = $person->postcode;

settype( $totalcharge , 'integer' );
settype( $displaytotalpaid , 'integer' );
settype( $totalremain , 'integer' );

include( "reg/header.inc" );

?>
<h2>Your registration details</h2>

<p>Congratulations! You've booked for <?= $event_longer ?>! Your booking id is <strong><?= $person->id ?></strong> and your password is <strong><?= htmlspecialchars($person->passwd) ?></strong> - please note these down now!</p>

<p>You should receive an email very shortly with your booking details.
If you don't see this, it may have been caught by a spamfilter - make
sure to check your Spam or Junk folder.</p>
<?php
if ( $person->cancelled == "1" ) {
	?>
  <p>This booking has been <strong>CANCELLED</strong>. If this is incorrect, contact <a href="mailto:bookings@bicon2010.org.uk">bookings@bicon2010.org.uk</a> immediately.</p>
  <?php
}

$totalcharge = $biconcharges->calculateCharge($person) + $bireconcharges->calculateCharge($person);

if ($person->paymentlevel && $person->bireconpaymentlevel) {
	# This person is coming to both BiCon and BiReCon.
	$biconpaymentlevel = $biconcharges->getBand($person)->label;
	$totalbiconcharge = $biconcharges->calculateDetailedCharge($person);
	$bireconpaymentlevel = $bireconcharges->getBand($person)->label;
	$totalbireconcharge = $bireconcharges->calculateDetailedCharge($person);
	 
	echo("<p>You are registered for both BiReCon and BiCon/ICB.</p>");
	echo("<ul>");
	echo("<li>You've chosen to register for BiReCon at payment level <strong>$bireconpaymentlevel.</strong>\n");
	echo("The charge for this is as follows: $totalbireconcharge.</li>\n");

	echo("<li>You've chosen to register for BiCon at payment level <strong>$biconpaymentlevel.</strong>\n");
	echo("The charge for this is as follows: $totalbiconcharge.</li>\n");

	echo("</ul>");
	echo("<p><strong>The total charge for the whole event is $currency$totalcharge.</strong></p>");
	
} else {

	$displaypaymentlevel = '';
	if ($person->paymentlevel) {
		$displaypaymentlevel = $biconcharges->getBand($person)->label;
		$detailedcharge = $biconcharges->calculateDetailedCharge($person);
			$other_event = 
'<p><div class="inset_box"> 
<div id="birecon_blurb"><p>You may also be interested in the BiReCon event which takes place the day before BiCon
and is a more academic style conference. The idea of BiReCon is for
people who research and write about bisexuality to feed back to the
international and national bi communities about what they are doing.
This year we have several international speakers (including activist
writer Robyn Ochs and editors of the Journal of Bisexuality) as well
as workshops and presentations about topics such as bisexuals in the
movies and being bi in the workplace. For more information about
BiReCon <a href="http://www.bicon2010.org.uk/bicon/birecon">see the BiReCon web site</a>.</p>

<p>As a registered BiCon attendee, you will be able to get a free day ticket 
to BiCeRon at the event. However, if you or your organisation wish to attend as an affiliated member
<a href="register_birecon.php">go to this page to register for BiReCon</a>.</p></div></div>';
	} elseif ($person->bireconpaymentlevel) {
		$displaypaymentlevel = $bireconcharges->getBand($person)->label;
		$detailedcharge = $bireconcharges->calculateDetailedCharge($person);
			$other_event = 
'<div class="inset_box"><div id="bicon_blurb"><p>You may also like to
register for the rest of the BiCon event which takes place over the
three days folowing BiReCon (August 27th-30th). During these days some of the
dialogues and debates started at BiReCon will continue and there will
be more chance to meet and socialise with members of the international
and national bi communities. For more details about BiCon see 
<a href="http://www.bicon2010.org.uk/">the BiCon 2010 web site</a>. To
register for BiCon <a href="register_bicon.php">go to this page</a>.</p></div></div>';
	}
	echo("<p>You've chosen to register at payment level <strong>$displaypaymentlevel.</strong>\n");
	echo("The charge for this is as follows: $detailedcharge.</p>");
	echo $other_event;
}

$displaytotalpaid = paidsofar( $person->id , $paidtable );
$totalremain = $totalcharge - $displaytotalpaid;
		
echo('<p>');

if ( $displaytotalpaid == 0 ) {
  ?>
  We have yet to process a payment from you.
  <?php

} else {
  ?>
  So far we have processed <strong><?= $currency . $displaytotalpaid ?></strong> from you.
  <?php
}

if ( $totalremain == 0 ) {
  ?>
  So you're fully paid up and booked - thank you very much!</p>
  <?php
} else {
	?>
  This leaves <font color='#cc0000'><strong><?= $currency . $totalremain ?></strong></font> to secure your booking. Information on how to pay may be found below.</p>
  <?
}

if ( $displaytotalpaid == 0 ) {
	?>
<p>If you <strong>preregistered</strong> then please email <a href="mailto:bookings@bicon2010.org.uk">bookings@bicon2010.org.uk</a> 
with your name, address and booking number and we will put your deposit toward your fee.</p>
	<?php
}

include( "reg/review.inc" );

if ( $totalremain > 0 ) {

    include( "reg/review-pay-with-paypal.inc" );

} else {

    echo( "<h2>Payment details</h2><p>You are fully paid up and confirmed - thank you!</p>" );

}
?>
<script language="javascript" type="text/javascript">

jQuery(document).ready(function() {

	var showBiReCon="Click here for information about BiReCon, the one-day academic conference before BiCon...";
	var hideBiReCon="Hide the BiReCon text";
	var showBiCon="Click here for information about BiCon, the three-day event after BiReCon...";
	var hideBiCon="Hide the BiCon text";

	jQuery("#birecon_blurb").before("<p><a href='#' id='toggle_birecon'>"+showBiReCon+"</a>");
	jQuery("#bicon_blurb").before("<p><a href='#' id='toggle_bicon'>"+showBiCon+"</a>");

  jQuery('#birecon_blurb').hide();
  jQuery('#bicon_blurb').hide();

	jQuery('a#toggle_birecon').click(function() {

		if (jQuery('a#toggle_birecon').text()==showBiReCon) {
			jQuery('a#toggle_birecon').text(hideBiReCon);
		}	else {
			jQuery('a#toggle_birecon').text(showBiReCon);
		}
	
		jQuery('#birecon_blurb').toggle('slow');
		return false;
		
	});

	jQuery('a#toggle_bicon').click(function() {

		if (jQuery('a#toggle_bicon').text()==showBiCon) {
			jQuery('a#toggle_bicon').text(hideBiCon);
		}	else {
			jQuery('a#toggle_bicon').text(showBiCon);
		}
	
		jQuery('#bicon_blurb').toggle('slow');
		return false;
		
	});

});
</script>
<?php

include( "reg/footer.inc" );

?>

