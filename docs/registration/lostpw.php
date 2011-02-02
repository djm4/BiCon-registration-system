<?php

require_once('../../inc/config.inc');

require_once('mysql.inc');
require_once('library.inc');

include("reg/header.inc");

?>                    

<h2>Booking id/password reminder</h2>

<p>
Enter the email address you used to book for BiCon 2010/10 ICB.
</p>

<form action="pwremind.php" method="post">
<input type="text" name="emailaddr" size=60>
<input type="submit" value="Send reminder">
</form>

<br>
<br>

<p>
If you no longer have access to that email address, please mail
<a href="mailto:bookings@bicon2010.org.uk">bookings@bicon2010.org.uk</a>
with your name, address, and as many details of your booking as you
can remember, and we'll try to track down your registration.
</p>

<?php include("reg/footer.inc"); ?>
