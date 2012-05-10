<li class="card <?php
		switch ($card->getCardType()) {
			case application\entities\Card::TYPE_CREATURE:
				echo 'creature';
				break;
			case application\entities\Card::TYPE_EVENT:
				echo 'event';
				break;
			case application\entities\Card::TYPE_ITEM:
				echo 'item';
				break;
		}
	?>" id="card_<?php echo $card->getId(); ?>">
	<div class="name <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE) echo $card->getFaction(); ?>" id="card_<?php echo $card->getId(); ?>_name"><?php echo strtoupper($card->getName()); ?></div>
	<div class="card_image" id="card_<?php echo $card->getId(); ?>_image">
		<img src="/images/cards/<?php echo $card->getKey(); ?>.png" class="main_image" id="card_<?php echo $card->getId(); ?>_image_image">
		<img src="/images/cards/<?php echo $card->getKey(); ?>.png" class="main_image reflection" id="card_<?php echo $card->getId(); ?>_image_reflection">
		<div class="cover"></div>
	</div>
	<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
		<div class="hp"><?php echo $card->getHP(); ?></div>
		<div class="magic"><?php echo ($card->getMPTIncreasePlayer()) ? '+'.$card->getMPTIncreasePlayer() : '-'; ?></div>
	<?php endif; ?>
</li>