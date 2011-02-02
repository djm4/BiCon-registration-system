<?php

$paypaltot = $totalremain + $surcharge;

?>


<h2>Payment options</h2>

<?php 
if ($currency_code == 'GBP' || $currency_code == 'EUR') {
  ?>

<p>We can accept payment by electronic bank transfer from people in the UK and Eurozone. This
is cheaper for us than PayPal, so is our preferred method of payment. If you would like to pay
in this way, our bank account details are as follows:</p>
<p>
Account name: BiCon 2010<br />
Account number: 016 33 872<br />
Sort code: 40-06-32</p>
<p>
IBAN (International Bank Account Number): GB92 MIDL 400632 01633872<br />
BIC (Branch Indentifier Code): MIDL GB2142T</p>
<p>
Please make sure you use your name and registration number as the reference code for
the payment. Also if you pay by installments please ensure installments are
a minimum of <?= $currency ?>10 each and ensure you have paid in full before BiCon.
</p>

	<?php
}
?>

<h3>PayPal</h3>

<p>
We are now accepting payment by <strong>Paypal</strong>.
</p>

<p>
The button below will bring you to the paypal website, where
you will be charged 
a total of
<font color="#ff0000"><strong><?= $currency . $paypaltot ?></strong></font>.
</p>

<p>
If this total is incorrect or you have
had prepayments not taken into account, <strong>do not pay yet</strong> but
email <a href="mailto:bookings@bicon2010.org.uk">bookings@bicon2010.org.uk</a>
with your booking ID (<strong><?= $person->id ?></strong>) and details of
your prepayment, so we can adjust this total appropriately.
</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<p>
Pay 
<font color="#ff0000"><strong><?= $currency . $paypaltot ?></strong></font>
to BiCon 2010 (paypal:paypal@bicon2010.org.uk)
<input type="hidden" name="notify_url" value="https://secure.10icb.org/registration/paypal-ipn.php">
<input type="hidden" name="return" value="https://secure.10icb.org/registration/">
<input type="hidden" name="image_url" value="https://secure.10icb.org/bicon/logo.jpg">
<input type="hidden" name="custom" value="<?= $person->id ?>">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="paypal@bicon2010.org.uk">
<input type="hidden" name="item_name" value="Bicon Registration">
<input type="hidden" name="item_number" value="id:<?= $person->id ?>">
<input type="hidden" name="amount" value="<?= $paypaltot ?>">
<input type="hidden" name="no_shipping" value="2">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="<?= $currency_code ?>">
<input type="hidden" name="lc" value="GB">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but23.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</p>
</form>

<h3>Pay by cheque</h3>

<p>
If you'd like to pay by <strong>cheque</strong> or <strong>postal order</strong>, please make it payable to
<strong>BiCon</strong> and send it, with a printout of this page OR your name, address and booking ID to:
</p>

<p>
Bicon 2010,<br>
BM Bicon,<br>
London<br>
WC1N 3XX<br>
UK
</p>
<?php

if ($person->event != 'BiReCon') {
    echo( "<h2>Pay by instalment</h2>
<p>
Alternatively, you may wish to pay in instalments. As with full payment you can do this by cheque, bank transfer (UK and Eurozone only) or by PayPal.</p>
<p>If you wish to pay via Paypal, enter the amount you would like to pay here, and proceed to the next page.
</p>

<p>
<form action='instalment.php' method='post'>
<input type='hidden' name='id' value='$person->id'>
<input type='hidden' name='totalremain' value='$totalremain'>
Enter amount: <input type='text' name='instalment'>
<input type='submit' value='Proceed to next page...'>
</p>

<p>Enter whole numbers only, please.</p>

" );
} 
?>



