<div class="backdrop_box large" id="login_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<h2>Add card reward</h2>
		<div class="content">Click the name of the card to add it as a reward</div>
		<br style="clear: both;">
		<?php foreach (array('creature', 'equippable_item', 'potion_item', 'event') as $type): ?>
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
						<div style="width: 260px; float: left;">
							<h6 style="margin-top: 15px;"><?php echo $description; ?></h6>
							<?php if (count($cards['creature'][$faction])): ?>
								<ul style="margin-left: 15px; list-style: none;">
									<?php foreach ($cards['creature'][$faction] as $card): ?>
										<li style="padding: 3px;">
											<a href="javascript:void(0);" id="add_reward_<?php echo $card->getUniqueId(); ?>" onclick="Devo.Admin.addCardReward('<?php echo $card->getUniqueId(); ?>', '<?php echo $tellable_type; ?>', <?php echo $tellable_id; ?>);"><img src="/images/spinning_16.gif" style="display: none;"><?php echo $card->getName(); ?></a>
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
									<a href="javascript:void(0);" id="add_reward_<?php echo $card->getUniqueId(); ?>" onclick="Devo.Admin.addCardReward('<?php echo $card->getUniqueId(); ?>', '<?php echo $tellable_type; ?>', <?php echo $tellable_id; ?>);"><img src="/images/spinning_16.gif" style="display: none;"><?php echo $card->getName(); ?></a>
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
