<?php $csp_response->setTitle('Dragon evo admin super powers!'); ?>
<div class="content admin-menu">
	<h2>Admin menu</h2>
	<h4>Edit cards</h4>
	<ul>
		<?php foreach (array('event', 'creature', 'item', 'potion') as $type): ?>
			<li>
				<?php echo link_tag(make_url('edit_cards', array('card_type' => $type)), "Edit {$type} cards"); ?><br>
				Click here to edit <?php echo $type; ?> cards
			</li>
		<?php endforeach; ?>
	</ul>
</div>