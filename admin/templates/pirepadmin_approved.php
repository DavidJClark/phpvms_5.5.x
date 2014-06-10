<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h2>PIREP Approved</h2>

PIREP #<?php echo $pirep->pirepid;?> has been approved<br />
Flight #<?php echo $pirep->code.$pirep->flightnum?> (<?php echo $pirep->depicao.' to '.$pirep->arricao?>)
<br /><br />
<a href="<?php echo adminurl('/pirepadmin/viewpending');?>">Click to go to the pending PIREPS page</a>