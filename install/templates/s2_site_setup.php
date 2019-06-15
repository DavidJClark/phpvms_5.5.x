<h2>Site Setup</h2>
<form action="?page=complete" method="post">
	<table width="550px" align="center">
	<tr>
		<td colspan="2">
			<strong>Now the final step. Provide your company and personal info below.</strong><br /><br />
			* - required fields
			<?php 
			if($message!='')
			{
				echo '<div id="error">'.$message.'</div>';
			}
			?>
			<br />
			<br />
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	
	<tr>
		<td colspan="2"><strong>Your Company Info</strong><br /><br /></td>
		<td></td>
	</tr>
	
	<tr>
		<td align="left" width="1px" nowrap valign="top"><strong>* Site Name: </strong></td>
		<td><input type="text" name="SITE_NAME" value="<?php echo $_POST['SITE_NAME']?>" />
			<p>Parent company, can be the same as your VA name.</p>
		</td>
	</tr>
	
	<tr>
		<td align="left" width="1px" nowrap valign="top"><strong>* Admin Email: </strong></td>
		<td><input type="text" name="ADMIN_EMAIL" value="<?php echo $_POST['ADMIN_EMAIL']?>" />
			<p>This is the email address pilots will see when approving PIREPS and sending email through the site.</p>
		</td>
	</tr>
	
	<tr>
		<td align="left" width="1px" nowrap valign="top"><strong>* Your Virtual Airline: </strong></td>
		<td><input type="text" name="vaname" value="<?php echo $_POST['vaname']?>" />
			<p>This is your first/main airline. You can add more later.</p>
		</td>
	</tr>
	
	<tr>
		<td align="left" width="1px" nowrap valign="top"><strong>* Your Airline's Code: </strong></td>
		<td><input type="text" name="vacode" value="<?php echo $_POST['vacode']?>" />
			<p >This is your airline's code (ie: VMS).</p>
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	
	<tr>
		<td colspan="2"><strong>Your User Details</strong><br /><br /></td>
		<td></td>
	</tr>
	<tr>
		<td align="left"><strong>* Your First Name: </strong></td>
		<td><input type="text" name="firstname" value="<?php echo $_POST['firstname']?>" />
			<p></p>
		</td>	
	</tr>
	
	<tr>
		<td align="left" width="1px" nowrap><strong>* Your Last Name: </strong></td>
		<td><input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>" />
			<p></p>
		</td>	
	</tr>
	
	<tr>
		<td align="left"><strong>* Your Email: </strong></td>
		<td><input type="text" name="email" value="<?php echo $_POST['email']?>" />
			<p>This is the email for your personal pilot account.</p>
		</td>
	</tr>
	
	<tr>
		<td align="left"><strong>* Your Password: </strong></td>
		<td><input type="text" name="password" value="<?php echo $_POST['password']?>" />
			<p></p>
		</td>
	</tr>
	
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	
	<tr>
		<td><input type="hidden" name="action" value="submitsetup" /></td>
		<td><input type="submit" name="submit" value="Finish!" /></td>
	</tr>
</table>
</form>
