<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sun, 31 Jan 2010 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");


$person = new BiConAttendee();

$warning = '';

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

require_once('Country.php');
$bicon_country = new BiConCountry();

include("reg/header.inc");

?>

<form method="post" action="register_2.php">
<input type="hidden" name="event" id="event" value="<?= $event ?>" />
<table border=0>

<tr>
<td colspan=2>
<h2>Registration - step 1 of 4: contact details</h2>
<?= $warning ?>
<p><?php 

if ($event == 'BiCon') {
  echo 'You are registering for BiCon/ICB. To register for BiReCon instead (the one-day academic conference'
	. ' on Thursday) <a href="register_1.php?event=BiReCon">click here</a>.';
} else {
  echo 'You are registering for BiReCon, the one-day academic conference.'
	. ' To register for BiCon/ICB, <a href="register_1.php?event=BiCon">click here</a>.';
}

?>
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
<td align="right"><label id="email">Email address</label></td>
<td><input type="text" name="email" id="email" value="<?= htmlspecialchars($person->email) ?>" class="required">* 
<div id="errorMessage_email" class="errorMessage">Please enter your email address</div></td>
</tr>

<tr>
<td align="right"><label for="emailrepeat">Re-type email address<br>(Just to be sure)</label></td>
<td><input type="text" name="emailrepeat" id="emailrepeat" value="<?= htmlspecialchars($person->email) ?>" class="required">* 
<div id="errorMessage_emailrepeat" class="errorMessage">Please confirm your e-mail address</div></td>
</tr>

<tr>
<td align="right"><label for="homephone">Phone number</label></td>
<td><input type="text" name="homephone" id="homephone" value="<?= htmlspecialchars($person->homephone) ?>">
<input type="hidden" name="mobilephone" value="unrequested"></td>
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
?>
<input type="radio" name="newcomerslist" value="1"<?= $newcomerslistyes ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="newcomerslist" value="0"<?= $newcomerslistno ?>>No</td>
</tr>
<tr>
  <td align="right">All BiCon and BiReCon attendees must read and agree to<br />
    <a href="http://www.bicon2010.org.uk/bicon/code-of-conduct" target="_blank">the BiCon Code of Conduct</a> (link opens in new window)</td>
  <td><input type="checkbox" name="conduct_agreed" id="conduct_agreed" value="yes" class="required"/>
    <label for="conduct_agreed">I have read and agree to the BiCon Code of Conduct *</label>
    <div id="errorMessage_conduct_agreed" class="errorMessage">Please read and agree to the BiCon Code of Conduct</div></td>
</tr>

<tr>
<td align="right">Ready for the next page?</td>
<td><input type="submit" value="Proceed to next page..."></td>
</table>
</form>

<?php include('reg/validate-form.inc'); ?>

<?php include("reg/footer.inc"); ?>
