<!-- Volunteer: YES -->


<tr>
<td colspan="2"><p>BiCon is entirely run by volunteers, and could not function without an army of people
giving up a few hours of their time to do small but important jobs at the event. Unfortunately, teams 
aren't always able to make full use of everyone who wants to help, so please don't be offended
if we don't end up taking you up on your offer. We're very grateful for all offers of help, whether
or not we end up using you.</p>
<p><strong>Would you like to...</strong></p>
</td>
</tr>

<?php 
$runworkshop = $person->checkBoxChecked('runworkshop');
$volcounselling = $person->checkBoxChecked('volcounselling');
$volsigner = $person->checkBoxChecked('volsigner');
$volfirstaid = $person->checkBoxChecked('volfirstaid');
$volrecep = $person->checkBoxChecked('volrecep');
$volgopher = $person->checkBoxChecked('volgopher');
$volsound = $person->checkBoxChecked('volsound');
$vollight = $person->checkBoxChecked('vollight');
$volchildcare = $person->checkBoxChecked('volchildcare');

?>

<tr>
<td align="right">...run or suggest a session?</td>
<td>
<input type="checkbox" name="runworkshop" value="yes"<?= $runworkshop[1] ?>>
</td>
</tr>
<tr>
<td align=right>Please give brief details of the session if you have them at this stage
(if not, we'll get in touch nearer the event to ask for more details.)
<td>
<input type="text" name="otherwsinfo" value="<?= $person->otherwsinfo ?>">
</td>

<tr>
<td align=right>...volunteer as a counsellor?</td>
<td>
<input type="checkbox" name="volcounselling" value="yes"<?= $volcounselling[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer as a signer?</td>
<td>
<input type="checkbox" name="volsigner" value="yes"<?= $volsigner[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer as a first aider?</td>
<td>
<input type="checkbox" name="volfirstaid" value="yes"<?= $volfirstaid[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer to help on reception?</td>
<td>
<input type="checkbox" name="volrecep" value="yes"<?= $volrecep[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer as a gopher?</td>
<td>
<input type="checkbox" name="volgopher" value="yes"<?= $volgopher[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer to help with sound tech?</td>
<td>
<input type="checkbox" name="volsound" value="yes"<?= $volsound[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer to help with lighting tech?</td>
<td>
<input type="checkbox" name="vollight" value="yes"<?= $vollight[1] ?>>
</td>
</tr>

<tr>
<td align=right>...volunteer to help with child care?</td>
<td>
<input type="checkbox" name="volchildcare" value="yes"<?= $volchildcare[1] ?>>
</td>
</tr>

<tr>
<td align=right>Any other areas you would like to help with?</td>
<td>
<input type="text" name="volother" value="<?= $person->volother ?>">
</td>
</tr>

<tr>
<td align=right>Please give specific information with regards 
to qualifications and experience where necessary, especially 
for counselling, first aid and child care where 
qualiications are an essential requirement.
<td>
<input type="text" name="volqualified" value="<?= $person->volqualified ?>">
</td>
</tr>

