<?php

require_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

include( 'reg/payment.inc' );

$biconcharges = new BiConCharges();
$bireconcharges = new BiReConCharges();

$logfilename = "$logfilepath/reg.log";

$i = 0;

if (!$logged_in) {

	include( "reg/header.inc" );

  echo("<h2>Registering for $event_longer</h2>\n");

	echo("<p>If you have yet to register, <a href='/registration/register_1.php'>visit our registration page</a>.");
//	echo("<p>On-line registration for BiCon/ICB/BiReCon has now closed.\n");
//	echo("You may still register for the events on the day by turning up and \n");
//	echo("paying at the Registration Desk, but please note that we will only" .
//			" be accepting cash.\n");
	
	echo( "<h2>Reviewing your registration</h2>
	<p>To review your registration details, please provide
	the booking number and password you received in your
	registration email.</p>" );
	
	$displayid = "";
	
	include( "reg/login.inc" );
	
	echo( "<p>If you no longer have your booking number or password,
	<a href='lostpw.php'>click here for a reminder</a>.</p>" );
	
	include( "reg/helping-hand-donation.inc" );
	
	include( "reg/footer.inc" );

} else {

  $person = $logged_in_person;

	$displayfirstname = htmlspecialchars($person->firstname);
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
  
	echo("<h2>Welcome back, " . htmlspecialchars($displayfirstname) . ".</h2>");

	echo("<p>If you're not $displayfirstname, <a href='logout.php'>click here to log out</a>.</p>");

	if ( $person->cancelled == "1" ) {
			echo("<p>This booking has been <strong>CANCELLED</strong>. If this is incorrect, contact ");
			echo("<a href=\"mailto:bookings@bicon2010.org.uk\">bookings@bicon2010.org.uk</a> immediately.</p>");
	}

	$totalcharge = $biconcharges->calculateCharge($person) + $bireconcharges->calculateCharge($person);

	include( "reg/helping-hand-donation.inc" );
	
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
'<div class="inset_box"> 
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

	echo("<p>");
	$preamble = '';
	
	if ( $displaytotalpaid == 0 ) {
	
			$preamble .= "We have yet to process a payment from you";
	
	} else {
	
			$preamble .= "So far we have processed <strong>" . $currency . $displaytotalpaid . "</strong> from you";
	
	}
	
	if ( $totalremain == 0 ) {
	
			$preamble .= ". So you're fully paid up and booked - thank you very much!</p>";
	
	} else {
	
			$preamble .= " leaving <font color='#cc0000'><strong>" . $currency . $totalremain . "</strong></font> to secure your booking. Information on how to pay may be found below.</p>";
	
	}
	
	if ( $displaytotalpaid == 0 ) {
	
			$preamble .= "<p>If you
			<strong>preregistered</strong> then please email
			<strong><a href=\"mailto:bookings@bicon2010.org.uk\">bookings@bicon2010.org.uk</a></strong> with your name,
			address and booking number and we will put your deposit
			toward your fee.</p>";
	
	}
	
	echo $preamble;
	
	#include( "reg/review-accom.inc" );
	
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
}
?>

