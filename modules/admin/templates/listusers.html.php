<?php 
	
	$csp_response->setTitle("List user's emails");
	
?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		List user's emails
	</h1>
	<h4>Comma-separated list of email addresses (<?php echo count($emails); ?>)</h4>
	<p>
		<?php echo join(', ', $emails); ?>
	</p>
</div>