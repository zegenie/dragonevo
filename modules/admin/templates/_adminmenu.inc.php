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
		<?php foreach (array('event', 'creature', 'item', 'potion') as $type): ?>
			<li>
				<?php echo link_tag(make_url('edit_cards', array('card_type' => $type)), "Edit {$type} cards"); ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<h1 style="margin-top: 25px;">Manage users</h1>
	<ul>
		<li><a href="#">Edit users</a></li>
	</ul>
	<h1 style="margin-top: 25px;">Manage games</h1>
	<ul>
		<li><a href="#">Show active games</a></li>
		<li><a href="#">Find finished games</a></li>
	</ul>
</div>