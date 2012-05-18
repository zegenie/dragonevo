<?php $csp_response->setTitle('Edit creature cards'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right admin-menu">
	<h4>
		Edit creature cards
		<a href="<?php echo make_url('new_card', array('card_type' => 'creature')); ?>" class="button button-standard" style="margin-left: 10px;">Create new card</a>
	</h4>
	<?php foreach (\application\entities\Card::getFactions() as $faction => $description): ?>
		<div class="feature" style="width: 190px;">
			<h6 style="margin-top: 15px;"><?php echo $description; ?></h6>
			<?php if (count($cards[$faction])): ?>
				<ul style="margin-left: 15px;">
					<?php foreach ($cards[$faction] as $card): ?>
						<li><a href="<?php echo make_url('edit_card', array('card_id' => $card->getB2DBID(), 'card_type' => 'creature')); ?>"><?php echo $card->getName(); ?></a>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<p>There are no <?php echo $description; ?> cards</p>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>