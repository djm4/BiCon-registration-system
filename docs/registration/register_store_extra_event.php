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

<table border=0>
<tr>
<td colspan=2><h2>Registration - registered for both events</h2>

<p>Thank you. You are now registered for both BiCon/ICB and BiReCon.</p>

<p><a href="index.php">Return to the main registration page to see revised pricing.</a></p>

</td>
</tr>
</table>

<?php include("reg/footer.inc"); ?>
