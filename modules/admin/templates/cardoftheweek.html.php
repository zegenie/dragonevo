<?php $csp_response->setTitle('Edit creature cards'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right cotw-admin">
	<h1>
		Edit card of the week
	</h1>
	<p>
		The card of the week is featured on the frontpage with its picture, details and description.
	</p>
	<h3>Current card of the week</h3>
	<?php if ($current_card instanceof application\entities\Card): ?>
		<div class="preview">
			<?php include_component('main/cardoftheweek', array('preview' => true)); ?>
		</div>
	<?php else: ?>
		<p>There is no card of the week set! The frontpage will not have it!</p>
	<?php endif; ?>
	<br style="clear: both;">
	<h3>Pick a new card of the week</h3>
	<p>
		Click the name of any card you want to select as card of the week. This card will be featured on the frontpage. Remember that the card must have a description!
	</p>
	<?php foreach (array('creature', 'item', 'event') as $type): ?>
		<div class="feature">
			<h4 style="margin-top: 15px;"><?php
			
				switch($type) {
					case 'item':
						echo 'Item cards';
						break;
					case 'event':
						echo 'Event cards';
						break;
					case 'creature':
						echo 'Creature cards';
						break;
				}

			?></h4>
			<?php if ($type == 'creature'): ?>
				<?php foreach (\application\entities\Card::getFactions() as $faction => $description): ?>
					<h6 style="margin-top: 15px;"><?php echo $description; ?></h6>
					<?php if (count($cards['creature'][$faction])): ?>
						<ul style="margin-left: 15px; list-style: none;">
							<?php foreach ($cards['creature'][$faction] as $card): ?>
								<li style="padding: 3px;">
									<?php if ($card->getLongDescription()): ?>
										<form method="post">
											<input type="hidden" name="selected_card" value="<?php echo "{$type}_{$card->getId()}"; ?>">
											<input type="submit" value="Pick" style="margin-right: 5px;">
											<?php echo $card->getName(); ?>
										</form>
									<?php else: ?>
										<button class="button disabled button-silver" title="This card doesn't have any description!" style="padding: 2px 5px !important; margin: -2px 5px 0 0;">Pick</button>
										<?php echo $card->getName(); ?><br>
										<span class="faded_out">This card doesn't have any description!</span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<p>There are no <?php echo $description; ?> cards</p>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>