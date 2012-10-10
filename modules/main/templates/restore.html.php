<?php $csp_response->setTitle('Dragon Evo:TCG ~ generate new password'); ?>
<div class="content login">
	<div class="menu-left<?php if ($csp_user->isAuthenticated()): ?> small<?php endif; ?>">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<?php if ($csp_user->isAuthenticated()): ?>
			<h4>You are already logged in</h4>
			<p style="padding-left: 30px;">
				Click to <a href="<?php echo make_url('logout'); ?>">log out</a>.
			</p>
		<?php elseif (isset($password_saved) && $password_saved): ?>
			<h4>See, that was easy!</h4>
			<p>
				The password you just specified has been saved.<br>
				Now, <a href="<?php echo make_url('login'); ?>">log in</a> and get playing!
			</p>
		<?php elseif (!$valid_code): ?>
			<h4>This is not a valid user / code combination</h4>
			<p style="padding-left: 30px;">
				You need a valid user / restore code to generate a new password.
			</p>
		<?php else: ?>
			<h1>Generate a new password</h1>
			<p>
				Enter your new password here. We'll send a confirmation email to your email address, just so you know it's been done.
			</p>
			<?php if (isset($error) && $error): ?>
				<p class="error" style="margin-bottom: 10px;">
					<?php echo $error; ?>
				</p>
			<?php endif; ?>
			<form accept-charset="utf-8" method="post" id="restore_form">
				<dt>
					<label class="login_fieldheader" for="desired_password"><?php echo __('Password'); ?></label>
				</dt>
				<dd>
					<input type="password" id="desired_password" name="desired_password_1" style="width: 200px;">
				</dd>
				<dt>
					<label class="login_fieldheader" for="desired_password_2"><?php echo __('Password'); ?> (repeat)</label>
				</dt>
				<dd>
					<input type="password" id="desired_password_2" name="desired_password_2" style="width: 200px;">
				</dd>
				<div style="padding: 20px 35px 20px 0; text-align: right;">
					<input type="submit" id="login_button" value="<?php echo __('Continue'); ?>" style="font-size: 1em;">
					<span id="login_indicator" style="display: none;"><?php echo image_tag('/images/spinning_20.gif'); ?></span>
				</div>
			</form>
		<?php endif; ?>
	</div>
</div>
