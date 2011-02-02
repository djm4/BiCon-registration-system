<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

$person = new BiConAttendee();
if ($logged_in) {
  // We shouldn't be logged-in at this page. If we are, it's possible that someone may
	// overwrite their current details with new ones without realising it. Log them out so
	// they're creating a new record, and then warn them that we've done it.
	//
	// Later, we may want to give them a choice of editing their logged-in record or
	// logging-out and creating a new one. But not just yet.
  
	$session->delete(false);
	$logged_in = false;
	$logged_in_person = null;
	$logged_in_person_id = 0;
	$warning = '<p><b>Important:</b> this page creates a new registration. If you want to review your '
	 . 'existing registration, <a href="index.php">go to the registration home page and log-in</a>.</p>';
}

$form = $_POST;
$person->readForm($form);

// Set the currency (this was previously derived from the country,
// but we decided that we needed to be able to change it).

if ($person->currency == '') {
	$person->currency = '£';
}

$person->save();
if (!$logged_in) {
	$session->create($person);
	$session->createCookie(true, true);
	$logged_in = true;
	$logged_in_person = $person;
}

include("reg/header.inc");

$bireconcharges = new BiReConCharges();
$biconcharges = new BiConCharges();

?>

<form method="post" action="register_3.php">

<table border=0>

<tr>
<td colspan=2><h2>Registration - step 2 of 4: registration rate</h2> <?= $warning ?>
</td>
</tr>

<tr>
<td colspan=2>Fields marked with a star (*) are essential.</td>
</tr>
<?php 

$region = $person->getRegion();
$currency = $person->getCurrency();

if ($region == 'ROW') {
	if ($event == 'BiReCon') {
  	?>
  
 <tr>
<td colspan=2>Registration forBiReCon from your country costs £50, plus £30 per night that you will be staying on-site. <input type="hidden" name="bireconpaymentlevel" value="A" /></td>
</tr>

  	<?php
	} else {
  	?>
  
 <tr>
<td colspan=2>Registration for BiCon/ICB from your country costs £30, plus £30 per night that you will be staying on-site. <input type="hidden" name="paymentlevel" value="A" /></td>
</tr>

  	<?php
	}

} else {
	if ($event == 'BiReCon') {
	 ?>
<tr>
<td colspan=2><?= $event_longer?>'s registration prices are available either at full price, or at a discounted rate for students.</td>
</tr>

<tr>
	<td colspan="2" align="center">
    <div id="pricing_table">
    <table cellpadding="2" border="2"><?= $bireconcharges->showBandTable($region, $currency); ?></table>
    </div>
  </td>
</tr>

<tr>
<td align="right"><label for="bireconpaymentlevel">Please choose your registration rate.</label></td>
<td>
<select name="bireconpaymentlevel" id="bireconpaymentlevel" class="required">
<?= $bireconcharges->showBands($region); ?>
</select> * 
<div id="errorMessage_bireconpaymentlevel" class="errorMessage">Please choose your payment band</div>
</td>
</tr>
	<?php
	} else {
	 ?>
<tr>
<td colspan=2><?= $event_longer?>'s ticket prices are based on your level of income, and the number of nights you will be staying on-site.</td>
</tr>
<tr>
	<td colspan="2" align="center">
    <div id="pricing_table">
    <table cellpadding="2" border="2"><?= $biconcharges->showBandTable($region, $currency); ?></table>
    </div>
  </td>
</tr>

<tr>
<td align="right"><label for="paymentlevel">Please choose your annual level of income<br>
 so that we may calculate your ticket price.</label></td>
<td>
<select name="paymentlevel" id="paymentlevel" class="required">
<?= $biconcharges->showBands($region); ?>
</select> * 
<div id="errorMessage_paymentlevel" class="errorMessage">Please choose your payment band</div>
</td>
</tr>
	<?php
  }
} 

$onsite_checked = '';
$offsite_checked = '';

if ($person->accommodation == 'on-site') {
	$onsite_checked = ' checked="checked"';
}

if ($person->accommodation == 'off-site') {
	$offsite_checked = ' checked="checked"';
}

$arriving_sel = array('', '', '', '', '', '');
$leaving_sel = array('', '', '', '', '', '');

if ($person->day_arriving != 0) {
  $arriving_sel[$person->day_arriving - 1] = ' selected="selected"';
} else {
  if ($event == 'BiReCon') {
    $arriving_sel[0] = ' selected="selected"';
	} else {
    $arriving_sel[1] = ' selected="selected"';
	}
}

if ($person->day_leaving != 0) {
  $leaving_sel[$person->day_leaving - 1] = ' selected="selected"';
} else {
  if ($event == 'BiReCon') {
  	$leaving_sel[2] = ' selected="selected"';
	} else {
    $leaving_sel[5] = ' selected="selected"';
	}
}

if (true) {
	?>
<tr>
<td colspan=2><p><strong>The accommodation deadline for <?= $event_longer ?> has passed; you can no longer book accommodation.</strong></p>
<input type="hidden" name="accommodation" value="off-site">
<p>Please let us know the days you will be arriving at and leaving <?= $event_longer?>, so that we can judge numbers.</p></td>
</tr>
	
	<?php
	
} else {

 ?>

<tr>
  <td align="right">Will you be staying on-site at <?= $event_longer?>?</td>
  <td><p>
    <input name="accommodation" type="radio" id="accommodation-on-site" value="on-site"<?= $onsite_checked ?> />
    <label for="accommodation-on-site">I will be staying on-site </label>*</p>
    <p>
      <input type="radio" name="accommodation" id="accommodation-off-site" value="off-site"<?= $offsite_checked ?> />
      <label for="accommodation-off-site">I will make my own accommodation arrangements</label> *</p></td>
</tr>
<tr>
<td colspan=2>If you will be staying on-site, please let us know the days you will be arriving at
and leaving <?= $event_longer?>.:</td>
</tr>
  <?php 
}
?>

<tr>
<td align="right"><label for="day_arriving">I will be arriving at <?= $event_longer?>:</label></td>
<td> 
  <select name="day_arriving" id="day_arriving">
    <option value="1"<?= $arriving_sel[0] ?>>Wednesday</option>
    <option value="2"<?= $arriving_sel[1] ?>>Thursday</option>
    <option value="3"<?= $arriving_sel[2] ?>>Friday</option>
    <option value="4"<?= $arriving_sel[3] ?>>Saturday</option>
    <option value="5"<?= $arriving_sel[4] ?>>Sunday</option>
    <option value="6"<?= $arriving_sel[5] ?>>Monday</option>
  </select>
</td>
</tr>
<td align="right"><label for="day_leaving">I will be leaving <?= $event_longer?>:</label></td>
<td>  
    <select name="day_leaving" id="day_leaving">
      <option value="1"<?= $leaving_sel[0] ?>>Wednesday</option>
      <option value="2"<?= $leaving_sel[1] ?>>Thursday</option>
      <option value="3"<?= $leaving_sel[2] ?>>Friday</option>
      <option value="4"<?= $leaving_sel[3] ?>>Saturday</option>
      <option value="5"<?= $leaving_sel[4] ?>>Sunday</option>
      <option value="6"<?= $leaving_sel[5] ?>>Monday</option>
        </select>
        </td>
</tr>
<tr>
<td colspan=2><h2>Next page</h2></td>
</tr>

<tr>
<td align="right">Ready for the next page?</td>
<td><input type="submit" value="Proceed to next page..."></td>
</table>
</form>

<?php include('reg/validate-form.inc'); ?>

<script language="javascript" type="text/javascript">

jQuery(document).ready(function() {

	var showPricing="Click to show the pricing table...";
	var hidePricing="Hide the pricing table";

	jQuery("#pricing_table").before("<p><a href='#' id='toggle_pricing'>" + showPricing + "</a>");

  jQuery('#pricing_table').hide();

	jQuery('a#toggle_pricing').click(function() {

		if (jQuery('a#toggle_pricing').text()==showPricing) {
			jQuery('a#toggle_pricing').text(hidePricing);
		}	else {
			jQuery('a#toggle_pricing').text(showPricing);
		}
	
		jQuery('#pricing_table').toggle('slow');
		return false;
		
	});

});
</script>

<?php include("reg/footer.inc"); ?>
