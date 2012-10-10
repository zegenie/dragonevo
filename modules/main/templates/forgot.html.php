<?php $csp_response->setTitle('Dragon Evo:TCG ~ Forgot username or password'); ?>
<div class="content login">
	<div class="menu-left<?php if ($csp_user->isAuthenticated()): ?> small<?php endif; ?>">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<?php if ($csp_user->isAuthenticated()): ?>
			<h5>You are already logged in</h5>
			<p style="padding-left: 30px;">
				Click to <a href="<?php echo make_url('logout'); ?>">log out</a>.
			</p>
		<?php elseif (isset($sent_details) && $sent_details): ?>
			<h5>Never fear, the help is near!</h5>
			<p>
				We've sent you an email with information on how to restore access to your account.
			</p>
			<p>
				Check your inbox.
			</p>
		<?php else: ?>
			<h1>Forgot your password?</h1>
			<p>
				Enter your username or email address here. If you've forgotten your username, enter your email address here.
			</p>
			<p>
				We'll send you an email containing your username, with instructions on how to generate a new password.
			</p>
			<?php if (isset($error) && $error): ?>
				<p class="error" style="margin-bottom: 10px;">
					<?php echo $error; ?>
				</p>
			<?php endif; ?>
			<form accept-charset="utf-8" action="<?php echo make_url('forgot'); ?>" method="post" id="login_form" <?php /*onsubmit="Devo.Main.Login.login('<?php echo make_url('login'); ?>'); return false;" */ ?>>
				<label class="login_fieldheader" for="userinfo" style="margin: 5px; font-size: 1.2em;"><?php echo __('Username or email address'); ?></label><br style="clear: both;">
				<input type="text" id="userinfo" name="userinfo" style="width: 350px; margin: 0 5px;" value="<?php echo $csp_request['userinfo']; ?>">
				<div style="padding: 20px 35px 20px 0; text-align: right;">
					<input type="submit" id="login_button" value="<?php echo __('Continue'); ?>" style="font-size: 1em;">
					<span id="login_indicator" style="display: none;"><?php echo image_tag('/images/spinning_20.gif'); ?></span>
				</div>
			</form>
		<?php endif; ?>
	</div>
</div>
