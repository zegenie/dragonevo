		<div class="tab_menu">
			<ul id="login_menu">
				<li id="tab_login"<?php if ($selected_tab == 'login'): ?> class="selected"<?php endif; ?>><?php echo javascript_link_tag(image_tag('/images/icon-login.png', array('style' => 'float: left;')).__('Login'), array('onclick' => "Devo.Main.Helpers.tabSwitcher(this, 'tab_login');")); ?></li>
				<li id="tab_register"<?php if ($selected_tab == 'register'): ?> class="selected"<?php endif; ?>><?php echo javascript_link_tag(image_tag('/images/icon-register.png', array('style' => 'float: left;')).__('Register new account'), array('onclick' => "Devo.Main.Helpers.tabSwitcher(this, 'tab_register');")); ?></li>
			</ul>
		</div>
		<div id="login_menu_panes">
			<div id="tab_login_pane"<?php if ($selected_tab != 'login'): ?> style="display: none;"<?php endif; ?>>
				<div class="logindiv regular">			
					<form accept-charset="utf-8" action="<?php echo make_url('login'); ?>" method="post" id="login_form" onsubmit="Devo.Main.Login.login('<?php echo make_url('login'); ?>'); return false;">
						<input type="hidden" id="return_to" name="return_to" value="<?php echo $referer; ?>" />
						<div class="login_boxheader"><?php echo __('Log in to an existing account'); ?></div>
						<div>
							<table border="0" class="login_fieldtable">
								<tr>
									<td><label class="login_fieldheader" for="devo_username"><?php echo __('Username'); ?></label></td>
									<td><input type="text" id="devo_username" name="csp_username" style="width: 200px;"></td>
								</tr>
								<tr>
									<td><label class="login_fieldheader" for="devo_password"><?php echo __('Password'); ?></label></td>
									<td><input type="password" id="devo_password" name="csp_password" style="width: 200px;"></td>
								</tr>
							</table>
							<br>
							<input type="submit" id="login_button" class="button button-silver" value="<?php echo __('Continue'); ?>">
							<span id="login_indicator" style="display: none;"><?php echo image_tag('/images/spinning_20.gif'); ?></span>
						</div>
					</form>
				</div>
			</div>
			<br style="clear: both;">
			<?php include_template('main/loginregister', array('selected_tab' => $selected_tab)); ?>
		</div>
		<div id="backdrop_detail_indicator" style="text-align: center; padding: 50px; display: none;">
			<?php echo image_tag('/images/spinning_32.gif'); ?>
		</div>
<?php if (isset($error)): ?>
	<script type="text/javascript">
		Devo.Main.Helpers.Message.error('<?php echo $error; ?>');
	</script>
<?php endif; ?>
<script type="text/javascript">
	<?php if (!$csp_request->isAjaxCall()): ?>
	document.observe('dom:loaded', function() {
	<?php endif; ?>
		$('devo_username').focus();
	<?php if (!$csp_request->isAjaxCall()): ?>
	});
	<?php endif; ?>
</script>