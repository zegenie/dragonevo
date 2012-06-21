<?php if ($card instanceof application\entities\Card): ?>
	<?php if (!$preview): ?>
		<h4>Card of the week: <?php echo $card->getName(); ?></h4>
	<?php endif; ?>
	<img src="/images/cards/<?php echo $card->getKey(); ?>.png" <?php if ($preview): ?> style="float: left; margin-right: 10px;"<?php endif; ?> class="card_preview">
	<p>
		<strong>Faction:</strong> <?php

			switch ($card->getFaction()) {
				case 'resistance':
					echo 'The Hologev';
					break;
				case 'neutrals':
					echo 'The Highwinds';
					break;
				case 'rutai':
					echo 'The Rutai';
					break;
			}

		?><br>
		<strong>Name:</strong> <?php echo $card->getName(); ?><br>
		<strong>Card type:</strong> <?php

			switch ($card->getCardType()) {
				case application\entities\Card::TYPE_CREATURE:
					echo 'Creature card';
					break;
				case application\entities\Card::TYPE_EVENT:
					echo 'Event card';
					break;
				case application\entities\Card::TYPE_POTION_ITEM:
					echo 'Potion card';
					break;
				case application\entities\Card::TYPE_EQUIPPABLE_ITEM:
					echo 'Item card';
					break;
			}

		?><br>
	</p>
	<?php if (!$preview): ?>
		<p>
			<?php echo nl2br($card->getLongDescription()); ?>
		</p>
		<a href="<?php echo make_url('unavailable'); ?>" class="read-more">Read more&nbsp;&gt;&gt;</a>
	<?php endif; ?>
<?php elseif (!$preview): ?>
	<p>
		Card of the week will appear here.
	</p>
<?php endif; ?>