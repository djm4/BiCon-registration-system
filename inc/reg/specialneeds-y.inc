<!-- Access requirements: YES -->

<tr>
<td colspan="2"><p>We try to run accessible event. We cannot guarantee any accessibility requirements, but will
do our best to meet any requirements that we're notified about in advance.</p>
</td>
</tr>

<?php 
$mhimp = $person->checkBoxChecked('mhimp');
$accessflat = $person->checkBoxChecked('accessflat');
$nostairs = $person->checkBoxChecked('nostairs');
$carerspace = $person->checkBoxChecked('carerspace');
$signer = $person->checkBoxChecked('signer');
$roomloop = $person->checkBoxChecked('roomloop');
$whitestick = $person->checkBoxChecked('whitestick');
$assistanimal = $person->checkBoxChecked('assistanimal');
$largeprint = $person->checkBoxChecked('largeprint');
$sightimp = $person->checkBoxChecked('sightimp');
$hearingimp = $person->checkBoxChecked('hearingimp');
$mobilityimp = $person->checkBoxChecked('mobilityimp');
 ?>
<tr>
<td align=right>Do you have a mobility impairment?</td>
<td>
<input type="radio" name="mobilityimp" value="yes"<?= $mobilityimp[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="mobilityimp" value="no"<?= $mobilityimp[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you have a hearing impairment?</td>
<td>
<input type="radio" name="hearingimp" value="yes"<?= $hearingimp[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="hearingimp" value="no"<?= $hearingimp[0] ?>>No
</td>
</tr>

 <tr>
<td align=right>Do you have a sight impairment?</td>
<td>
<input type="radio" name="sightimp" value="yes"<?= $sightimp[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="sightimp" value="no"<?= $sightimp[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you have a mental health issue
you would like us to be aware of?</td>
<td>
<input type="radio" name="mhimp" value="yes"<?= $mhimp[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="mhimp" value="no"<?= $mhimp[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require a fully accessible flat?</td>
<td>
<input type="radio" name="accessflat" value="yes"<?= $accessflat[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="accessflat" value="no"<?= $accessflat[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require access with no stairs?</td>
<td>
<input type="radio" name="nostairs" value="yes"<?= $nostairs[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="nostairs" value="no"<?= $nostairs[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require space for a carer?</td>
<td>
<input type="radio" name="carerspace" value="yes"<?= $carerspace[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="carerspace" value="no"<?= $carerspace[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require a signer or lip speaker?</td>
<td>
<input type="radio" name="signer" value="yes"<?= $signer[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="signer" value="no"<?= $signer[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require a room loop?</td>
<td>
<input type="radio" name="roomloop" value="yes"<?= $roomloop[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="roomloop" value="no"<?= $roomloop[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require a white stick?</td>
<td>
<input type="radio" name="whitestick" value="yes"<?= $whitestick[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="whitestick" value="no"<?= $whitestick[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you need to bring an assistance animal?</td>
<td>
<input type="radio" name="assistanimal" value="yes"<?= $assistanimal[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="assistanimal" value="no"<?= $assistanimal[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Do you require materials in large print?</td>
<td>
<input type="radio" name="largeprint" value="yes"<?= $largeprint[1] ?>>Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="largeprint" value="no"<?= $largeprint[0] ?>>No
</td>
</tr>

<tr>
<td align=right>Is there anything else you feel we should know?</td>
<td>
<input type="text" name="otherdisinfo" value="<?= $person->otherdisinfo ?>">
</td>
</tr>

<tr>
<td align=right>Is there someone specific you need<br>
to share a flat with to help you?</td>
<td>
<input type="text" name="needtoshare" value="<?= $person->needtoshare ?>">
</td>
</tr>

