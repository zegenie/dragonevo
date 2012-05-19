<?php $csp_response->setTitle('Lobby'); ?>
<div class="content login">
	<div class="menu-left<?php if ($csp_user->isAuthenticated()): ?> small<?php endif; ?>">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<?php if ($csp_user->isAuthenticated()): ?>
			<h4>You are already logged in</h4>
			<p style="padding-left: 30px;">
				Click to <?php echo link_tag('logout', 'log out'); ?>.
			</p>
		<?php else: ?>
			<h1>Login</h1>
			<p>
				If you have an account, login here.
			</p>
			<?php if (isset($error) && $error): ?>
				<p class="error" style="margin-bottom: 10px;">
					<?php echo $error; ?>
				</p>
			<?php endif; ?>
			<form accept-charset="utf-8" action="<?php echo make_url('login'); ?>" method="post" id="login_form" <?php /*onsubmit="Devo.Main.Login.login('<?php echo make_url('login'); ?>'); return false;" */ ?>>
				<dt>
					<label class="login_fieldheader" for="devo_username"><?php echo __('Username'); ?></label>
				</dt>
				<dd>
					<input type="text" id="devo_username" name="csp_username" style="width: 200px;">
				</dd>
				<dt>
					<label class="login_fieldheader" for="devo_password"><?php echo __('Password'); ?></label>
				</dt>
				<dd>
					<input type="password" id="devo_password" name="csp_password" style="width: 200px;">
				</dd>
				<div style="padding: 20px 35px 20px 0; text-align: right;">
					<input type="submit" id="login_button" value="<?php echo __('Continue'); ?>" style="font-size: 1em;">
					<span id="login_indicator" style="display: none;"><?php echo image_tag('/images/spinning_20.gif'); ?></span>
				</div>
			</form>
		<?php endif; ?>
	</div>
</div>
