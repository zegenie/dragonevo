<div class="backdrop_box large" id="login_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<h2>Add AI card</h2>
		<div class="content">Enter the card level (for creature cards) next to the card and click "Add" to add it as an AI card. Click "Done" or "Close" when you're done.</div>
		<br style="clear: both;">
		<?php foreach (array('creature', 'equippable_item', 'potion_item') as $type): ?>
			<div <?php if ($type != 'creature') echo ' style="width: 380px; float: left;"'; ?>>
				<h4 style="margin-top: 15px;"><?php

					switch($type) {
						case 'equippable_item':
							echo 'Item cards';
							break;
						case 'potion_item':
							echo 'Potion cards';
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
						<div style="width: 380px; float: left;">
							<h6 style="margin-top: 15px;"><?php echo $description; ?></h6>
							<?php if (count($cards['creature'][$faction])): ?>
								<ul style="margin-left: 15px; list-style: none;">
									<?php foreach ($cards['creature'][$faction] as $card): ?>
										<li style="padding: 3px;">
											<form id="add_opponent_<?php echo $card->getUniqueId(); ?>_form" method="post" onsubmit="Devo.Admin.addCardOpponent(this);return false;">
												<input type="hidden" name="tellable_type" value="<?php echo $tellable_type; ?>">
												<input type="hidden" name="tellable_id" value="<?php echo $tellable_id; ?>">
												<input type="hidden" name="card_id" value="<?php echo $card->getUniqueId(); ?>">
												<input type="submit" id="add_opponent_<?php echo $card->getUniqueId(); ?>_button" value="Add">
												Level <input type="text" style="width: 25px;" name="card_level" value="1"><?php echo $card->getName(); ?>
											</form>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else: ?>
								<p>There are no <?php echo $description; ?> cards</p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<br style="clear: both;">
				<?php else: ?>
					<?php if (count($cards[$type])): ?>
						<ul style="margin-left: 15px; list-style: none;">
							<?php foreach ($cards[$type] as $card): ?>
								<li style="padding: 3px;">
									<form id="add_opponent_<?php echo $card->getUniqueId(); ?>_form" method="post" onsubmit="Devo.Admin.addCardOpponent(this);return false;">
										<input type="hidden" name="tellable_type" value="<?php echo $tellable_type; ?>">
										<input type="hidden" name="tellable_id" value="<?php echo $tellable_id; ?>">
										<input type="hidden" name="card_id" value="<?php echo $card->getUniqueId(); ?>">
										<input type="submit" id="add_opponent_<?php echo $card->getUniqueId(); ?>_button" value="Add">
										<?php echo $card->getName(); ?>
									</form>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else: ?>
						<p>There are no <?php echo $description; ?> cards</p>
					<?php endif; ?>
					<br style="clear: both;">
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<br style="clear: both;">
	</div>
	<div class="backdrop_detail_footer">
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();">Close</a>
	</div>
</div>
