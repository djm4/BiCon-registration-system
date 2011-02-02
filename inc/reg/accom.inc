<!-- Accommodation -->

<tr>
<td align=right width="35%">Do you require a parking space?</td>
<td width="65%">
<input type="radio" name="parkingspace" value="yes">Yes&nbsp;&nbsp;&nbsp;
<input type="radio" name="parkingspace" value="no" CHECKED>No
</td>
</tr>

<tr>
<td align=right>Do you have a preference for which floor your flat
is on?</td>
<td>
<select name="flatpref">
<option value="" SELECTED>No preference</option>
<option value="ground">Ground floor, please</option>
<option value="higher">First floor or higher, please</option>
</select>
</td>
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
</select>
</td>
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
</select>
</td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"></td>
</tr>

<tr>
<td rowspan="3" align="right">Now you get to name up to three people
you would like to share a flat with. No guarantees, but we'll do
our best.</td>
<td>
<select name="sharewith1">
<option value="">No preference</option>
<option value="share" SELECTED>I would like to share with</option>
<option value="notshare">I would not like to share with</option>
</select>&nbsp;<input type="text" name="sharewith1name">
</td>
</tr>

<tr>
<td>
<select name="sharewith2">
<option value="">No preference</option>
<option value="share" SELECTED>I would like to share with</option>
<option value="notshare">I would not like to share with</option>
</select>&nbsp;<input type="text" name="sharewith2name">
</td>
</tr>
<tr>
<td>
<select name="sharewith3">
<option value="">No preference</option>
<option value="share" SELECTED>I would like to share with</option>
<option value="notshare">I would not like to share with</option>
</select>&nbsp;<input type="text" name="sharewith3name">
</td>
</tr>

<tr>
<td colspan="2" align=center><hr width="35%"></td>
</tr>

<tr>
<td align=right>Have you any other information or requests we
should know about?</td>
<td>
<input type="text" name="othershareinfo">
</td>
</tr>

