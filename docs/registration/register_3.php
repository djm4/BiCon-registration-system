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

if ($person->event == 'BiReCon') {
	$charges = new BiReConCharges();
} else {
	$charges = new BiConCharges();
}
$band = $charges->getBand($person);
$displaypaymentlevel = $band->label;


?>

<form method="post" action="register_4.php">

<table border=0>
<tr>
<td colspan=2><h2>Registration - step 3 of 4: optional details</h2>

<p>Pricing confirmation: You've are registering at payment level <strong><?= $displaypaymentlevel ?>.</strong>
The charge for this is as follows: <?= $charges->calculateDetailedCharge($person); ?>.
</p>

</td>
</tr>

<tr>
<td colspan=2><h2>Optional details</h2></td>
</tr>

<tr>
<td colspan=2>
If you answer yes to any of these questions,
we'll ask for a few more details on the next page.</td>
</tr>

<tr>
<td align="right">
Do you have any specific access requirements?<br>
</td>
<td>
<select name="specialneeds">
<option value="no" SELECTED>No</option>
<option value="yes">Yes</option>
</select>
</td>
</tr>

<tr>
<td align="right">
How many children will you be bringing to <?= $event_longer ?>?
</td>
<td>
<select name="numkids">
<option value="0" SELECTED>None</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Would you like to volunteer to help at <?= $event_longer ?>?<br>
</td>
<td>
<select name="optionvolunteer">
<option value="no" SELECTED>No</option>
<option value="yes">Yes</option>
</select>
</td>
</tr>
<?php 
if ($person->event != 'BiReCon') {
  ?>
<tr>
<td align="right">
Do you wish to apply for the Helping Hand fund?
</td>
<td>
<select name="helpinghand">
<option value="no" SELECTED>No</option>
<option value="yes">Yes</option>
</select>
</td>
</tr>
  <?php 
} 
?>
<tr>
<td colspan=2><h2>Next page</h2></td>
</tr>

<tr>
<td align="right">Ready for the next page?</td>
<td><input type="submit" value="Proceed to next page..."></td>
</table>
</form>

<?php include("reg/footer.inc"); ?>
