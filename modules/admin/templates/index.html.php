<?php $csp_response->setTitle('Market'); ?>
<div class="content admin-menu">
	<h2>Admin menu</h2>
	<h4>Edit cards</h4>
	<ul>
		<?php foreach (array('event', 'creature', 'item', 'special') as $type): ?>
			<li>
				<?php echo link_tag(make_url('edit_cards', array('card_type' => $type)), "Edit {$type} cards"); ?><br>
				Click here to edit <?php echo $type; ?> cards
			</li>
		<?php endforeach; ?>
	</ul>
</div>