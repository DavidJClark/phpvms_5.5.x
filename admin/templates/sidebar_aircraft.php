<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Tasks</h3>
<ul class="filetree treeview-famfamfam">
	<li><span class="file">
		<a href="<?php echo adminurl('/operations/aircraft');?>">View aircraft</a>
	</span></li>

	<li><span class="file">
		<a href="<?php echo adminurl('/operations/addaircraft');?>">Add an aircraft</a>
	</span></li>

	<li><span class="file">
		<a href="<?php echo adminaction('/import/exportaircraft'); ?>">Export Aircraft</a>
	</span></li>
	<li><span class="file">
		<a href="<?php echo adminurl('/import/importaircraft');?>">Import Aircraft</a>
	</span></li>
</ul>
<h3>Help</h3>
<p>Add the aircraft that your VA operates from here. The aircraft name 
	is what is displayed in schedules. The ICAO and the full name are used for reference.</p>