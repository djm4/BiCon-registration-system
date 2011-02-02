<?php

include_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

$person = new BiConAttendee();
if ($logged_in) {
	$person = $logged_in_person;
}

$form = $_POST;
$person->readForm($form);
$person->save();
if (!$logged_in) {
	$session->create($person);
	$session->createCookie(true, true);
	$logged_in = true;
	$logged_in_person = $person;
}

include("reg/header.inc");

?>
<h2>Registration - Page 4 of 4</h2>

<form action='register_store.php' method='post'>

<p>
Thanks, <?= htmlspecialchars($person->firstname) ?>! We're almost there. If you ticked yes for
any of the optional sections then we have a few more questions for you.
</p>

<p>
If you could answer these, we'll send an email to your address
<strong><?= htmlspecialchars($person->email) ?></strong>
(we've got that right, haven't we?)
confirming your registration and explaining
the methods of payment - and also how to check your details at a later date.
</p>


<table width=100%>

<tr><td colspan=2><h2>Accommodation</h2></td></tr>

<!-- Accommodation -->

<tr>
<td align=right width="35%">Do you require a parking space (please note that we're
unable to supply on-site parking before 5pm on Friday)?</td>
<td width="65%">
<input type="radio" name="parkingspace" value="yes">Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="parkingspace" value="no" CHECKED>No</td>
</tr>

<? if ($person->accommodation == 'on-site') {
  ?>

<tr>
<td align=right>Do you have a preference for which floor your flat
is on?</td>
<td>
<select name="flatpref">
<option value="" SELECTED>No preference</option>
<option value="ground">Ground floor, please</option>
<option value="higher">First floor or higher, please</option>
</select></td>
</tr>

<tr>
<td align=right>Would you like to be in a party flat or a quiet flat?</td>
<td>
<select name="sharenoise">
<option value="">No preference</option>
<option value="share" SELECTED>I would like to be in</option>
<option value="notshare">I would not like to be in</option>
</select>&nbsp;<select name="sharenoisewhich">
<option value="" SELECTED>No preference</option>
<option value="party">a party flat</option>
<option value="noisy">a noisy (but not party) flat</option>
<option value="quiet">a quiet flat</option>
</select></td>
</tr>

<tr>
<td align=right>Would you like to share with people of a particular
diet preference?</td>
<td>
<select name="sharediet">
<option value="">No preference</option>
<option value="share" SELECTED>I would like to share with</option>
<option value="notshare">I would not like to share with</option>
</select>&nbsp;<select name="sharedietwhich">
<option value="" SELECTED>No preference</option>
<option value="vegan">vegans</option>
<option value="vegetarian">vegetarians</option>
<option value="noalcohol">non-alcohol drinkers</option>
</select></td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"></td>
</tr>

<tr>
<td align="right">If you have any preferences for who
you would like to share a flat with, please list them here. <br />
No guarantees, but we'll do our best.</td>
<td>&nbsp;
  <input name="sharewith1name" type="text" size="60">  &nbsp;&nbsp;</td>
</tr>


<tr>
<td colspan="2" align=center><hr width="35%"></td>
</tr>

<tr>
<td align=right>Have you any other information or requests we
should know about?</td>
<td>
<input type="text" name="othershareinfo"></td>
</tr>

  <?php
} 
?>

<tr><td colspan=2><h2>Access requirements</h2></td></tr>

<?php
if ( $form['specialneeds'] == "yes" ) {
    include( "reg/specialneeds-y.inc" );
} else {
    include( "reg/specialneeds-n.inc" );
}
?>

<tr><td colspan=2><h2>Children</h2></td></tr>

<?php 
if ( $person->numkids != 0 ) {
    include( "reg/kids-y.inc" );
} else {
    include( "reg/kids-n.inc" );
}
?>

<tr><td colspan=2><h2>Volunteering</h2></td></tr>

<?php
if ( $form['optionvolunteer'] == "yes" ) { 
		echo('<input type="hidden" name="volunteer" value="yes">');
    include( "reg/volunteer-y.inc" );
} else {
		echo('<input type="hidden" name="volunteer" value="no">');
    include( "reg/volunteer-n.inc" );
}


if ($person->event != 'BiReCon') {
  ?>
<tr><td colspan=2><h2>Helping Hand Fund</h2></td></tr>

	<?php 
  if ( $person->helpinghand == 1 ) {
      include( "reg/helpinghand-y.inc" );
  } else {
      include( "reg/helpinghand-n.inc" );
  }
}
?>

<tr><td colspan=2><h2>Everything else</h2></td></tr>

<?php 
include( "reg/misc.inc" );
?>

<tr>
<td colspan=2><hr></td>
</tr>

<tr>
<td align=right>All done?</td>
<td><input type="submit" value="Register for <?= $event_longer ?>!" /></td>
</tr>
</table>

<input type="hidden" name="regnow" value="yes" />

</form>


<?php include("reg/footer.inc"); ?>
