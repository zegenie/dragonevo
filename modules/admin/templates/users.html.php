<?php 
	
	$csp_response->setTitle('Manage users'); 
	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');
	
?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Manage users (<?php echo count($users); ?>)
	</h1>
	<form action="<?php echo make_url('admin_say'); ?>" id="users_form">
		<ul class="admin_list">
			<?php foreach ($users as $user): ?>
				<li>
					<img src="/images/spinning_16.gif" style="display: none;" class="indicator" id="user_<?php echo $user->getId(); ?>_indicator">
					<div class="button-group">
						<a href="javascript:void(0);" id="user_<?php echo $user->getId(); ?>_button" class="button button-silver button-icon first last" onclick="Devo.Main.Helpers.popup(this);"><img src="/images/settings_small.png"></a>
						<div class="popup-menu">
							<ul>
								<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.resetSkills(<?php echo $user->getId(); ?>);">Reset all user's trained skills and level</a></li>
								<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.forgotPassword(<?php echo $user->getId(); ?>, '<?php echo make_url('forgot'); ?>', '<?php echo $user->getUsername(); ?>');">Send "forgot password?" email</a></li>
								<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.resetCards(<?php echo $user->getId(); ?>);">Release all user cards from games</a></li>
								<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.removeCards(<?php echo $user->getId(); ?>);">Remove all user cards</a></li>
								<?php foreach ($faction_names as $faction => $f_name): ?>
									<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.generateStarterPack(<?php echo $user->getId(); ?>, '<?php echo $faction; ?>');">Generate new <?php echo $f_name; ?> starter pack</a></li>
								<?php endforeach; ?>
								<li><a href="javascript:void(0);" onclick="Devo.Admin.Users.generatePotionPack(<?php echo $user->getId(); ?>);">Give user 5 new potions</a></li>
							</ul>
						</div>
					</div>
					<strong><?php echo $user->getUsername(); ?></strong><br>
					registered <?php echo date('d-m-Y, H:i', $user->getCreatedAt()); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</form>
</div>