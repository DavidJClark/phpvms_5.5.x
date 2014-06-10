<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Aircraft Import</h3>
<form enctype="multipart/form-data" action="<?php echo adminurl('/import/importaircraft');?>" method="post">
Choose your import file (*.csv): <br />
	<input name="uploadedfile" type="file" /><br />
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	
	<br />
	<input type="checkbox" name="header" checked /> First line of CSV is the header
	<br /><br />
	<input type="submit" value="Upload File" />

</form>