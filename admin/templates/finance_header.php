<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div style="float: right;">
<table width="100%">
<tr>
<td align="right">
<form action="<?php echo adminurl('/finance/viewreport');?>" method="get">
<strong>Select Report: </strong>
<?php
$years = StatsData::GetYearsSinceStart();
$months = StatsData::GetMonthsSinceStart();
$months = array_reverse($months, true);
?>
<select name="type">
	<option value="" <?php echo ($_GET['type']=='')?'selected="selected"':''?>>View Summary</option>
<?php
/*
 * Get the years since the VA started
 */
foreach($years as $yearname=>$timestamp)
{
	# Get the one that's currently selected
	if($_GET['type'] == 'y'.$timestamp)
		$selected = 'selected="selected"';
	else
		$selected = '';
	
?>
	<option value="<?php echo 'y'.$timestamp?>" <?php echo $selected?>>Yearly: <?php echo $yearname?></option>
	<?php
}

/*
 * Get all the months since the VA started
 */

foreach($months as $monthname=>$timestamp)
{
	# Get the one that's currently selected
	if($_GET['type'] == 'm'.$timestamp)
		$selected = 'selected="selected"';
	else
		$selected = '';
		
?>
	<option value="<?php echo 'm'.$timestamp?>" <?php echo $selected?>>Monthly: <?php echo $monthname?></option>
<?php
}
?>
</select>
<input type="submit" name="submit" value="View Report" />
</form>
</td>
<td align="right">
<form action="<?php echo adminurl('finance/viewreport'); ?>" method="get">
	<strong>Filter Financials: </strong>
	<input type="text" name="query" 
		value="<?php if($_GET['query']) { echo $_GET['query'];} else { echo '(Use % for wildcard)';}?>" onClick="if(this.value=='(Use % for wildcard)') this.value='';" />
    <?php if($_GET['type']) $type = $_GET['type']; else $type = ''; ?>
	<select name="type">
		<option value="code" <?php if($type == 'code') {echo 'selected';} ?>>code</option>
		<option value="flightnum" <?php if($type == 'flightnum') {echo 'selected';} ?>>flight number</option>
		<option value="depapt" <?php if($type == 'depapt') {echo 'selected';} ?>>departure airport</option>
		<option value="arrapt" <?php if($type == 'arrapt') {echo 'selected';} ?>>arrival airport</option>
		<option value="aircraft" <?php if($type == 'aircraft') {echo 'selected';} ?>>aircraft type</option>
	</select>
	<input type="hidden" name="action" value="filter" />
	<input type="submit" name="submit" value="filter" />
</form>
</td>
</tr>
</table>
</div>
