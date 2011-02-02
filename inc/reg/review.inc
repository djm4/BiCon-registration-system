<h2>Your contact details</h2>

<p>
The contact details we have for you are:
</p>

<?php

$address = array();
if ($addr1) { $address[] = $addr1; }
if ($addr2) { $address[] = $addr2; }
if ($addr3) { $address[] = $addr3; }
if ($town) { $address[] = $town; }
if ($county) { $address[] = $county; }
if ($postcode) { $address[] = $postcode; }
if ($country) { $address[] = $country; }

echo "
<P>
$displayfirstname $displaysurname<br>" . join(", ", $address) . "<br>
$displayemail
</p>";

?>

<p>
If you'd like to change these, please mail <a href="mailto:bookings@bicon2010.org.uk">bookings@bicon2010.org.uk</a> with
your booking id and old & new details.
</p>
