<div class="menu-left">
	<img src="/images/swirl_top_right.png" class="swirl top-right">
	<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
	<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
	<img src="/images/swirl_top_left.png" class="swirl top-left">
	<h1>Manage site</h1>
	<ul>
		<li><a href="<?php echo make_url('admin_card_of_the_week'); ?>">Pick card of the week</a></li>
		<li><a href="#">Pick item of the week</a></li>
		<li><a href="<?php echo make_url('admin_news'); ?>">Manage news</a></li>
		<li><a href="#">Manage media</a></li>
	</ul>
	<h1 style="margin-top: 25px;">Edit cards</h1>
	<ul>
		<?php foreach (array('event' => 'event', 'creature' => 'creature', 'equippable_item' => 'equippable', 'potion_item' => 'potion') as $type => $description): ?>
			<li>
				<?php echo link_tag(make_url('edit_cards', array('card_type' => $type)), "Edit {$description} cards"); ?>
			</li>
		<?php endforeach; ?>
		<li><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Dialog.show('Do you really want to reset all user cards?', 'All users will have their cards removed and will have to pick a new starter pack from scratch.', {yes: {href: '<?php echo make_url('admin_reset_user_cards'); ?>'}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});">Reset all user cards</a></li>
		<li><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Dialog.show('Do you really want to reset all games?', 'All users will have their games removed and will have to initiate any games over', {yes: {href: '<?php echo make_url('admin_reset_games'); ?>'}, no: {click: function() {Devo.Main.Helpers.Dialog.dismiss();}}});">Reset all games</a></li>
	</ul>
	<h1 style="margin-top: 25px;">Stories and quests</h1>
	<ul>
		<li><a href="<?php echo make_url('admin_tellables', array('tellable_type' => 'story')); ?>">Edit stories</a></li>
		<li><a href="<?php echo make_url('admin_tellables', array('tellable_type' => 'adventure')); ?>">Edit adventures</a></li>
	</ul>
	<h1 style="margin-top: 25px;">Manage users</h1>
	<ul>
		<li><a href="<?php echo make_url('admin_users'); ?>">Edit users</a></li>
		<li><a href="<?php echo make_url('admin_skills'); ?>">Edit available skills</a></li>
	</ul>
	<h1 style="margin-top: 25px;">Manage games</h1>
	<ul>
		<li><a href="<?php echo make_url('admin_games_ongoing'); ?>">Show active games</a></li>
		<li><a href="<?php echo make_url('admin_games_finished'); ?>">Show finished games</a></li>
	</ul>
</div>