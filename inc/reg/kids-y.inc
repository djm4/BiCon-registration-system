<!-- Kids: YES -->
<?php 
$select_array = array('', '', '', '', '', '', '', '', '', '');
$kidsunderfive = $person->selectArray('kidsunderfive', $select_array);
$kidsfivetoseven = $person->selectArray('kidsfivetoseven', $select_array);
$kidseighttoeleven = $person->selectArray('kidseighttoeleven', $select_array);
$kidstwelvetofifteen = $person->selectArray('kidstwelvetofifteen', $select_array);
$kidssixteen = $person->selectArray('kidssixteen', $select_array);
$kidsseventeen = $person->selectArray('kidsseventeen', $select_array);
$creche = $person->selectArray('creche', $select_array);
$accomlist = $person->selectArray('accomlist', $select_array);
 ?>
<tr>
<td align="right">
How many of the children you are bringing
are under five years old?
</td>
<td>
<select name="kidsunderfive">
<option value="0"<?= $kidsunderfive[0] ?>>None</option>
<option value="1"<?= $kidsunderfive[1] ?>>1</option>
<option value="2"<?= $kidsunderfive[2] ?>>2</option>
<option value="3"<?= $kidsunderfive[3] ?>>3</option>
<option value="4"<?= $kidsunderfive[4] ?>>4</option>
<option value="5"<?= $kidsunderfive[5] ?>>5</option>
<option value="6"<?= $kidsunderfive[6] ?>>6</option>
<option value="7"<?= $kidsunderfive[7] ?>>7</option>
<option value="8"<?= $kidsunderfive[8] ?>>8</option>
<option value="9"<?= $kidsunderfive[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Between five and seven?
(inclusive)
</td>
<td>
<select name="kidsfivetoseven">
<option value="0"<?= $kidsfivetoseven[0] ?>>None</option>
<option value="1"<?= $kidsfivetoseven[1] ?>>1</option>
<option value="2"<?= $kidsfivetoseven[2] ?>>2</option>
<option value="3"<?= $kidsfivetoseven[3] ?>>3</option>
<option value="4"<?= $kidsfivetoseven[4] ?>>4</option>
<option value="5"<?= $kidsfivetoseven[5] ?>>5</option>
<option value="6"<?= $kidsfivetoseven[6] ?>>6</option>
<option value="7"<?= $kidsfivetoseven[7] ?>>7</option>
<option value="8"<?= $kidsfivetoseven[8] ?>>8</option>
<option value="9"<?= $kidsfivetoseven[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Between eight and eleven?
(inclusive)
</td>
<td>
<select name="kidseighttoeleven">
<option value="0"<?= $kidseighttoeleven[0] ?>>None</option>
<option value="1"<?= $kidseighttoeleven[1] ?>>1</option>
<option value="2"<?= $kidseighttoeleven[2] ?>>2</option>
<option value="3"<?= $kidseighttoeleven[3] ?>>3</option>
<option value="4"<?= $kidseighttoeleven[4] ?>>4</option>
<option value="5"<?= $kidseighttoeleven[5] ?>>5</option>
<option value="6"<?= $kidseighttoeleven[6] ?>>6</option>
<option value="7"<?= $kidseighttoeleven[7] ?>>7</option>
<option value="8"<?= $kidseighttoeleven[8] ?>>8</option>
<option value="9"<?= $kidseighttoeleven[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Between twelve and fifteen?
(inclusive)
</td>
</td>
<td>
<select name="kidstwelvetofifteen">
<option value="0"<?= $kidstwelvetofifteen[0] ?>>None</option>
<option value="1"<?= $kidstwelvetofifteen[1] ?>>1</option>
<option value="2"<?= $kidstwelvetofifteen[2] ?>>2</option>
<option value="3"<?= $kidstwelvetofifteen[3] ?>>3</option>
<option value="4"<?= $kidstwelvetofifteen[4] ?>>4</option>
<option value="5"<?= $kidstwelvetofifteen[5] ?>>5</option>
<option value="6"<?= $kidstwelvetofifteen[6] ?>>6</option>
<option value="7"<?= $kidstwelvetofifteen[7] ?>>7</option>
<option value="8"<?= $kidstwelvetofifteen[8] ?>>8</option>
<option value="9"<?= $kidstwelvetofifteen[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Sixteen years old?
</td>
<td>
<select name="kidssixteen">
<option value="0"<?= $kidssixteen[0] ?>>None</option>
<option value="1"<?= $kidssixteen[1] ?>>1</option>
<option value="2"<?= $kidssixteen[2] ?>>2</option>
<option value="3"<?= $kidssixteen[3] ?>>3</option>
<option value="4"<?= $kidssixteen[4] ?>>4</option>
<option value="5"<?= $kidssixteen[5] ?>>5</option>
<option value="6"<?= $kidssixteen[6] ?>>6</option>
<option value="7"<?= $kidssixteen[7] ?>>7</option>
<option value="8"<?= $kidssixteen[8] ?>>8</option>
<option value="9"<?= $kidssixteen[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
Seventeen years old?
</td>
<td>
<select name="kidsseventeen">
<option value="0"<?= $kidsseventeen[0] ?>>None</option>
<option value="1"<?= $kidsseventeen[1] ?>>1</option>
<option value="2"<?= $kidsseventeen[2] ?>>2</option>
<option value="3"<?= $kidsseventeen[3] ?>>3</option>
<option value="4"<?= $kidsseventeen[4] ?>>4</option>
<option value="5"<?= $kidsseventeen[5] ?>>5</option>
<option value="6"<?= $kidsseventeen[6] ?>>6</option>
<option value="7"<?= $kidsseventeen[7] ?>>7</option>
<option value="8"<?= $kidsseventeen[8] ?>>8</option>
<option value="9"<?= $kidsseventeen[9] ?>>9</option>
</select>
</td>
</tr>

<tr>
<td align="right">
If offsite creche were available at an extra charge,<br>
would you be interested?
</td>
<td>
<select name="creche">
<option value="no"<?= $creche[0] ?>>No
<option value="yes"<?= $creche[1] ?>>Yes
</select>
</td>
</tr>

<tr>
<td align="right">
As we are unable to provide onsite accommodation for
families with children this year, would you like us to
provide you with a list of nearby hotels and B&Bs?
</td>
<td>
<select name="accomlist">
<option value="no"<?= $accomlist[0] ?>>No
<option value="yes"<?= $accomlist[1] ?>>Yes
</select>
</td>
</tr>

