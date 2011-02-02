<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

$person = new BiConAttendee();
if ($logged_in) {
	$person = $logged_in_person;
} else {
	$session->create($person);
	$session->createCookie(true, true);
	$logged_in = true;
	$logged_in_person = $person;
}

include("reg/header.inc");

$bireconcharges = new BiREConCharges();

?>

<form method="post" action="register_store_extra_event.php">

<table border=0>

<tr>
<td colspan=2><h2>Registration - register for BiReCon</h2> <?= $warning ?>
</td>
</tr>

<tr>
<td colspan=2>Fields marked with a star (*) are essential.</td>
</tr>
<?php 

$region = $person->getRegion();
$currency = $person->getCurrency();

if ($region == 'ROW') {
 	?>
  
 <tr>
<td colspan=2>Registration forBiReCon from your country costs US $50, plus US $30 per night that you will be staying on-site. <input type="hidden" name="bireconpaymentlevel" value="A" /></td>
</tr>

  <?php
} else {
	?>
<tr>
<td colspan=2>BiReCon's registration prices are available either at full price, or at a discounted rate for students.</td>
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
  $arriving_sel[1] = ' selected="selected"';

}

if ($person->day_leaving != 0) {
  $leaving_sel[$person->day_leaving - 1] = ' selected="selected"';
} else {
  $leaving_sel[5] = ' selected="selected"';

}

 ?>

<tr>
  <td align="right">Will you be staying on-site at BiReCon and BiCon/10ICB? Note that for joint bookings like this, accommodation for Wednesday and Thurdsay nights will be charged at BiReCon rates; accommodation on other nights will be charged at BiCon rates.</td>
  <td><p>
    <input name="accommodation" type="radio" id="accommodation-on-site" value="on-site"<?= $onsite_checked ?> />
    <label for="accommodation-on-site">I will be staying on-site </label>*</p>
    <p>
      <input type="radio" name="accommodation" id="accommodation-off-site" value="off-site"<?= $offsite_checked ?> />
      <label for="accommodation-off-site">I will make my own accommodation arrangements</label> *</p></td>
</tr>
<tr>
<td colspan=2>If you will be staying on-site, please let us know the days you will be arriving at
and leaving  BiReCon and BiCon/10ICB.:</td>
</tr>
<tr>
<td align="right"><label for="day_arriving">I will be arriving at BiReCon and BiCon/10ICB:</label></td>
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
<td align="right"><label for="day_leaving">I will be leaving BiReCon and BiCon/10ICB:</label></td>
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
