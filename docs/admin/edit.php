<?php

require_once('../../inc/config.inc');

include( "auth.inc" );

require_once('mysql.inc');
require_once('library.inc');
require_once('Country.php');

$bicon_country = new BiConCountry();

$person_id = $_GET['id'];
$person = new BiConAttendee();
$person->load($person_id);
$region = $person->getRegion();
$currency = $person->getCurrency();

$bireconcharges = new BiReConCharges();
$biconcharges = new BiConCharges();

# $user = $_SERVER['PHP_AUTH_USER'];

?>

<html>
<head>
<title>Bicon 2010 registrations</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/static/admin.css">
</head>

<body>

<p><a href="edit.php?id=<?= $person_id - 1 ?>">Previous</a> 
  | <a href="index.php">Booking index</a> 
  | <a href="edit.php?id=<?= $person_id + 1 ?>">Next</a></p>

<p><a href="booking.php?id=<?= $person_id ?>">View</a></p>

<form method="post" action="store.php">
<input type="hidden" name="id" value="<?= $person_id ?>" />
<input type="hidden" name="page_view" value="view" />
<table border=0>

<tr>
<td colspan=2>
<h2>Editing user details</h2>
</td>
</tr>

<tr>
<td colspan=2>Fields marked with a star (*) are essential.</td>
</tr>

<tr>
<td align="right" width="50%"><label for="firstname">First name</label></td>
<td width="50%"><input type="text" name="firstname" id="firstname" 
  value="<?= htmlspecialchars($person->firstname) ?>" class="required"> * 
<div id="errorMessage_firstname" class="errorMessage">Please enter your first name(s)</div></td>
</tr>

<tr>
<td align="right"><label for="surname">Last name</label></td>
<td><input type="text" name="surname" id="surname" value="<?= htmlspecialchars($person->surname) ?>" class="required">* 
<div id="errorMessage_surname" class="errorMessage">Please enter your last name</div></td>
</tr>

<tr>
<td align="right"><label for="addr1">Address Line 1</label></td>
<td><input type="text" name="addr1" id="addr1" value="<?= htmlspecialchars($person->addr1) ?>" class="required"> * 
<div id="errorMessage_addr1" class="errorMessage">Please enter the first line of your address</div></td>
</tr>

<tr>
<td align="right"><label for="line2">Line 2</label></td>
<td><input type="text" name="addr2" id="addr2" value="<?= htmlspecialchars($person->addr2) ?>"></td>
</tr>

<tr>
<td align="right"><label for="addr3">Line 3</label></td>
<td><input type="text" name="addr3" id="addr3" value="<?= htmlspecialchars($person->addr3) ?>"></td>
</tr>

<tr>
<td align="right"><label for="town">Town</label></td>
<td><input type="text" name="town" id="town" value="<?= htmlspecialchars($person->town) ?>" class="required">
* 
<div id="errorMessage_town" class="errorMessage">Please enter your town</div></td>
</tr>

<tr>
<td align="right"><label for="county">County/State/Region</label></td>
<td><input type="text" name="county" id="county" value="<?= htmlspecialchars($person->county) ?>"></td>
</tr>

<tr>
<td align="right"><label for="postcode">Postal/Zip code</label></td>
<td><input type="text" name="postcode" id="postcode" value="<?= htmlspecialchars($person->postcode) ?>"></td>
</tr>

<tr>
<td align="right"><label for="country">Country</label></td>
<td><select name="country" id="country" class="required"><?= $bicon_country->dropDown($person->country); ?></select>* 
<div id="errorMessage_country" class="errorMessage">Please enter your country</div></td>
</tr>

<tr>
<td align="right"><label for="email">Email address</label></td>
<td><input type="text" name="email" id="email" value="<?= htmlspecialchars($person->email) ?>" class="required">* 
<div id="errorMessage_email" class="errorMessage">Please enter your email address</div></td>
</tr>

<tr>
<td align="right"><label for="homephone">Phone number</label></td>
<td><input type="text" name="homephone" id="homephone" value="<?= htmlspecialchars($person->homephone) ?>">
<input type="hidden" name="mobilephone" value="unrequested"></td>
</tr>

<tr>
<td align="right"><label for="passwd">Password</label></td>
<td><input type="text" name="passwd" id="passwd" value="<?= htmlspecialchars($person->passwd) ?>" class="required">* 
<div id="errorMessage_passwd" class="errorMessage">Please enter your password</div></td>
</tr>

<tr>
<td align="right">We'll email you about completing your registration 
and payment. However, how would you like to 
receive your conference information pack?</td>
<td>
<?php 
$contactemail = '';
$contactpost = '';
if ($person->contactmethod == 'post') {
  $contactpost = ' selected="selected"';
} else {
  $contactemail = ' selected="selected"';
}
?>
<select name="contactmethod">
	<option value="email"<?= $contactemail ?>>By email</option>
	<option value="post"<?= $contactpost ?>>In the post</option>
</select></td>
</tr>

<tr>
<td align="right">May we pass your contact info<br>
to future BiCon &amp; ICB organisers?</td>
<td>
<?php 
$futurebiconsyes = '';
$futurebiconsno = '';
if ($person->futurebicons == 1) {
  $futurebiconsyes = ' checked="checked"';
} else {
  $futurebiconsno = ' checked="checked"';
}
?>
<input type="radio" name="futurebicons" value="1"<?= $futurebiconsyes ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="futurebicons" value="0"<?= $futurebiconsno ?>>No</td>
</tr>

<tr>
<td align="right">Would you like to be added to our<br>
'newcomers to BiCon/ICB' mailing list?</td>
<td>
<?php 
$newcomerslistyes = '';
$newcomerslistno = '';
if ($person->newcomerslist == 1) {
  $newcomerslistyes = ' checked="checked"';
} else {
  $newcomerslistno = ' checked="checked"';
}
$conduct_agreed = '';
if ($person->conduct_agreed) {
  $conduct_agreed = ' checked="checked"';
}
  ?>
<input type="radio" name="newcomerslist" value="1"<?= $newcomerslistyes ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="newcomerslist" value="0"<?= $newcomerslistno ?>>No</td>
</tr>
<tr>
  <td align="right">All BiCon and BiReCon attendees must read and agree to<br />
    <a href="http://www.bicon2010.org.uk/bicon/code-of-conduct" target="_blank">the BiCon Code of Conduct</a> (link opens in new window)</td>
  <td><input type="checkbox" name="conduct_agreed" id="conduct_agreed" value="yes" class="required"<?= $conduct_agreed ?>/>
    <label for="conduct_agreed">I have read and agree to the BiCon Code of Conduct *</label>
    <div id="errorMessage_conduct_agreed" class="errorMessage">Please read and agree to the BiCon Code of Conduct</div></td>
</tr>

<tr>
<td align="right">Is the booking cancelled?</td>
<td>
<?php 
$cancelledyes = '';
$cancelledno = '';
if ($person->cancelled == 1) {
  $cancelledyes = ' checked="checked"';
} else {
  $cancelledno = ' checked="checked"';
}
?>
<input type="radio" name="cancelled" value="1"<?= $cancelledyes ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="cancelled" value="0"<?= $cancelledno ?>>No</td>
</tr>

<tr>
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"><h2>Registration</h2></td>
</tr>

<tr>
  <td align="right"><label for="bireconpaymentlevel">Please choose your registration rate for BiReCon.</label></td>
  <td>
    <select name="bireconpaymentlevel" id="bireconpaymentlevel">
      <?= $bireconcharges->showBands($region, $person->bireconpaymentlevel); ?>
    </select> * 
    <div id="errorMessage_bireconpaymentlevel" class="errorMessage">Please choose your payment band</div>
  </td>
</tr>

<tr>
  <td align="right"><label for="paymentlevel">Please choose your annual level of income<br>
    so that we may calculate your ticket price. for BiCon</label></td>
  <td>
    <select name="paymentlevel" id="paymentlevel">
     <?= $biconcharges->showBands($region, $person->paymentlevel); ?>
    </select> * 
    <div id="errorMessage_paymentlevel" class="errorMessage">Please choose your payment band</div>
  </td>
</tr>

<?php 

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
  $arriving_sel[0] = ' selected="selected"';
}

if ($person->day_leaving != 0) {
  $leaving_sel[$person->day_leaving - 1] = ' selected="selected"';
} else {
  $leaving_sel[5] = ' selected="selected"';
}

 ?>

<tr>
  <td align="right">Will you be staying on-site at BiCon/BiReCon?</td>
  <td><p>
    <input name="accommodation" type="radio" id="accommodation-on-site" value="on-site"<?= $onsite_checked ?> />
    <label for="accommodation-on-site">I will be staying on-site </label>*</p>
    <p>
      <input type="radio" name="accommodation" id="accommodation-off-site" value="off-site"<?= $offsite_checked ?> />
      <label for="accommodation-off-site">I will make my own accommodation arrangements</label> *</p></td>
</tr>
<tr>
<td colspan=2>If you will be staying on-site, please let us know the days you will be arriving at
and leaving BiCon/BiReCon.:</td>
</tr>
<tr>
<td align="right"><label for="day_arriving">I will be arriving at BiCon/BiReCon:</label></td>
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
<td align="right"><label for="day_leaving">I will be leaving BiCon/BiReCon:</label></td>
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
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>


<tr>
<td colspan="2" align=center><hr width="35%"><h2>Accessibility</h2></td>
</tr>

<?php 
$accessyes = '';
$accessno = '';
if ($person->specialneeds) {
  $accessyes = ' selected="selected"';
} else {
  $accessno = ' selected="selected"';
}
?>
<tr>
  <td align="right">
    Do you have any specific access requirements?<br>
  </td>
  <td>
    <select name="specialneeds">
      <option value="no"<?= $accessno ?>>No</option>
      <option value="yes"<?= $accessyes ?>>Yes</option>
    </select>
  </td>
</tr>

<div id="accessibility_yes">
<?php include( "reg/specialneeds-y.inc" ); ?>
</div>
<tr>
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>


<tr>
<td colspan="2" align=center><hr width="35%"><h2>Children</h2></td>
</tr>

<?php 
$numkids_sel = array('', '', '', '', '', '', '', '', '', '');

if ($person->numkids) {
  $numkids_sel[$person->numkids] = ' selected="selected"';
} else {
  $numkids_sel[0] = ' selected="selected"';
}
 ?>
<tr>
  <td align="right">
    How many children will you be bringing to BiCon/BiReCon?
  </td>
  <td>
    <select name="numkids">
      <option value="0"<?= $numkids_sel[0] ?>>None</option>
      <option value="1"<?= $numkids_sel[1] ?>>1</option>
      <option value="2"<?= $numkids_sel[2] ?>>2</option>
      <option value="3"<?= $numkids_sel[3] ?>>3</option>
      <option value="4"<?= $numkids_sel[4] ?>>4</option>
      <option value="5"<?= $numkids_sel[5] ?>>5</option>
      <option value="6"<?= $numkids_sel[6] ?>>6</option>
      <option value="7"<?= $numkids_sel[7] ?>>7</option>
      <option value="8"<?= $numkids_sel[8] ?>>8</option>
      <option value="9"<?= $numkids_sel[9] ?>>9</option>
    </select>
  </td>
</tr>

<div id="kids_yes">
<?php include( "reg/kids-y.inc" ); ?>
</div>

<tr>
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"><h2>Volunteering</h2></td>
</tr>

<?php 
$volunteeryes = '';
$volunteerno = '';
if ($person->volunteer) {
  $volunteeryes = ' selected="selected"';
} else {
  $volunteerno = ' selected="selected"';
}
?>
<tr>
  <td align="right">
    Would you like to volunteer to help at BiCon/BiReCon?<br>
  </td>
  <td>
    <select name="volunteer">
      <option value="no"<?= $volunteerno ?>>No</option>
      <option value="yes" <?= $volunteeryes ?>>Yes</option>
    </select>
  </td>
</tr>
<div id="volunteer_yes">
<?php include( "reg/volunteer-y.inc" ); ?>
</div>

<tr>
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"><h2>Helping Hand Fund</h2></td>
</tr>

<?php 
$helpinghandyes = '';
$helpinghandno = '';
if ($person->helpinghand) {
  $helpinghandyes = ' selected="selected"';
} else {
  $helpinghandno = ' selected="selected"';
}
?>
<tr>
  <td align="right">
    Do you wish to apply for the Helping Hand fund?
  </td>
  <td>
    <select name="helpinghand">
      <option value="no"<?= $helpinghandno ?>>No</option>
      <option value="yes"<?= $helpinghandyes ?>>Yes</option>
    </select>
  </td>
</tr>
<div id="helpinghand_yes">
<?php include( "reg/helpinghand-y.inc" ); ?>
</div>

<tr>
<td colspan="2" align=center><hr width="35%"><h2>Accommodation</h2></td>
</tr>

<?php 
$parkingspaceyes = '';
$parkingspaceno = '';
if ($person->parkingspace) {
  $parkingspaceyes = ' checked="checked"';
} else {
  $parkingspaceno = ' checked="checked"';
}
?>
<tr>
  <td align=right>Do you require a parking space?</td>
  <td>
  <input type="radio" name="parkingspace" value="yes"<?= $parkingspaceyes ?>>Yes&nbsp;&nbsp;&nbsp;
  <input type="radio" name="parkingspace" value="no"<?= $parkingspaceno ?>>No</td>
</tr>

<?php 
$flatpref = array('' => '', 'ground' => '', 'higher' => '');
if ($person->flatpref) {
	$flatpref[$person->flatpref] = ' selected="selected"';
}
 ?>
<tr>
  <td align=right>Do you have a preference for which floor your flat is on?</td>
  <td>
    <select name="flatpref">
     <option value=""<?= $flatpref[''] ?>>No preference</option>
     <option value="ground"<?= $flatpref['ground'] ?>>Ground floor, please</option>
     <option value="higher"<?= $flatpref['higher'] ?>>First floor or higher, please</option>
    </select>
  </td>
</tr>

<?php 
$sharenoise = array('' => '', 'share' => '', 'notshare' => '');
if ($person->sharenoise) {
	$sharenoise[$person->sharenoise] = ' selected="selected"';
}
$sharenoisewhich = array('' => '', 'party' => '', 'noisy' => '', 'quiet' => '');
if ($person->sharenoisewhich) {
	$sharenoisewhich[$person->sharenoisewhich] = ' selected="selected"';
}
 ?>
 <tr>
<td align=right>Would you like to be in a party flat or a quiet flat?</td>
<td>
<select name="sharenoise">
<option value=""<?= $sharenoise[''] ?>>No preference</option>
<option value="share"<?= $sharenoise['share'] ?>>I would like to be in</option>
<option value="notshare"<?= $sharenoise['notshare'] ?>>I would not like to be in</option>
</select>&nbsp;<select name="sharenoisewhich">
<option value=""<?= $sharenoisewhich[''] ?>>No preference</option>
<option value="party"<?= $sharenoisewhich['party'] ?>>a party flat</option>
<option value="noisy"<?= $sharenoisewhich['noisy'] ?>>a noisy (but not party) flat</option>
<option value="quiet"<?= $sharenoisewhich['quiet'] ?>>a quiet flat</option>
</select></td>
</tr>

<?php 
$sharediet = array('' => '', 'share' => '', 'notshare' => '');
if ($person->sharediet) {
	$sharediet[$person->sharediet] = ' selected="selected"';
}
$sharedietwhich = array('' => '', 'vegan' => '', 'vegetarian' => '', 'noalcohol' => '');
if ($person->sharedietwhich) {
	$sharedietwhich[$person->sharedietwhich] = ' selected="selected"';
}
 ?>
<tr>
  <td align=right>Would you like to share with people of a particular diet preference?</td>
  <td>
    <select name="sharediet">
      <option value=""<?= $sharediet[''] ?>>No preference</option>
      <option value="share"<?= $sharediet['share'] ?>>I would like to share with</option>
      <option value="notshare"<?= $sharediet['notshare'] ?>>I would not like to share with</option>
    </select>&nbsp;<select name="sharedietwhich">
      <option value=""<?= $sharedietwhich[''] ?>>No preference</option>
      <option value="vegan"<?= $sharedietwhich['vegan'] ?>>vegans</option>
      <option value="vegetarian"<?= $sharedietwhich['vegetarian'] ?>>vegetarians</option>
      <option value="noalcohol"<?= $sharedietwhich['noalcohol'] ?>>non-alcohol drinkers</option>
    </select>
  </td>
</tr>

<tr>
<td align="right">If you have any preferences for who
you would like to share a flat with, please list them here. <br />
No guarantees, but we'll do our best.</td>
<td>&nbsp;
  <input name="sharewith1name" type="text" size="60" value="<?= $person->sharewith1name ?>"></td>
</tr>

<tr>
<td align=right>Have you any other information or requests we should know about?</td>
<td>
<input type="text" name="othershareinfo" value="<?= $person->othershareinfo ?>"></td>
</tr>

<tr><td colspan=2><h2>Everything else</h2></td></tr>

<?php 
include( "reg/misc.inc" );
?>

<tr>
  	<td>&nbsp;</td><td><input type="submit" name="submit" value="Store changes" /></td>
</tr>


</table>
</form>