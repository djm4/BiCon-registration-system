<!-- Miscellaneous -->
<?php 
$select_array = array('', '', '', '', '', '',
  '', '', '', '', '', '',
  '', '', '', '', '', '',
  '', '', '', '', '', '', '');
$howmanybicons = $person->selectArray('howmanybicons', $select_array);
 ?>
<tr><th colspan=2>Miscellaneous</th></tr>

<tr>
<td align=right>How many BiCons have you been to before?</td>
<td>
<select name="howmanybicons">
<option value="0"<?= $howmanybicons[0] ?>>This is my first</option>
<option value="1"<?= $howmanybicons[1] ?>>1</option>
<option value="2"<?= $howmanybicons[2] ?>>2</option>
<option value="3"<?= $howmanybicons[3] ?>>3</option>
<option value="4"<?= $howmanybicons[4] ?>>4</option>
<option value="5"<?= $howmanybicons[5] ?>>5</option>
<option value="6"<?= $howmanybicons[6] ?>>6</option>
<option value="7"<?= $howmanybicons[7] ?>>7</option>
<option value="8"<?= $howmanybicons[8] ?>>8</option>
<option value="9"<?= $howmanybicons[9] ?>>9</option>
<option value="10"<?= $howmanybicons[10] ?>>10</option>
<option value="11"<?= $howmanybicons[11] ?>>11</option>
<option value="12"<?= $howmanybicons[12] ?>>12</option>
<option value="13"<?= $howmanybicons[13] ?>>13</option>
<option value="14"<?= $howmanybicons[14] ?>>14</option>
<option value="15"<?= $howmanybicons[15] ?>>15</option>
<option value="16"<?= $howmanybicons[16] ?>>16</option>
<option value="17"<?= $howmanybicons[17] ?>>17</option>
<option value="18"<?= $howmanybicons[18] ?>>18</option>
<option value="19"<?= $howmanybicons[19] ?>>19</option>
<option value="20"<?= $howmanybicons[20] ?>>20</option>
<option value="21"<?= $howmanybicons[21] ?>>21</option>
<option value="22"<?= $howmanybicons[22] ?>>22</option>
<option value="23"<?= $howmanybicons[23] ?>>23</option>
<option value="24"<?= $howmanybicons[24] ?>>24</option>
</select>
</td>
</tr>

</tr>

<tr>
<td align=right>How did you first hear about <?= $event_longer ?>?</td>
<td>
<input type="text" name="firstheard" value="<?= $person->firstheard ?>">
</td>
</tr>

<tr>
<td align=right>Which newspaper/event etc have you heard about <?= $event_longer ?> from?</td>
<td>
<input type="text" name="heardfromwhat" value="<?= $person->heardfromwhat ?>">
</td>
</tr>

<tr>
<td align=right>Is there any other information that you feel we should know
about your booking?</td>
<td>
<input type="text" name="othernotes" value="<?= $person->othernotes ?>">
</td>
</tr>

<tr>
<td align=right>Anything you'd like to say about what you're looking for
from <?= $event_longer ?>?</td>
<td>
<input type="text" name="lookingfor" value="<?= $person->lookingfor ?>">
</td>
</tr>

