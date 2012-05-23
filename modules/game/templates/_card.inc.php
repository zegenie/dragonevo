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
	?> <?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE) echo $card->getFaction(); ?>" id="card_<?php echo $card->getId(); ?>">
	<div class="name" id="card_<?php echo $card->getId(); ?>_name"><?php echo strtoupper($card->getName()); ?></div>
	<div class="card_image" id="card_<?php echo $card->getId(); ?>_image" style="background-image: url('/images/cards/<?php echo $card->getKey(); ?>.png');">
		<?php /*<img src="/images/cards/<?php echo $card->getKey(); ?>.png" class="main_image" id="card_<?php echo $card->getId(); ?>_image_image"> */ ?>
	</div>
	<div class="card_reflection">
		<img src="/images/cards/<?php echo $card->getKey(); ?>.png" id="card_<?php echo $card->getId(); ?>_image_reflection">
		<div class="cover"></div>
	</div>
	<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
		<div class="attacks">
			<?php foreach ($card->getAttacks() as $attack): ?>
				<?php include_component('game/cardattack', compact('attack')); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<?php if ($card->getCardType() == application\entities\Card::TYPE_CREATURE): ?>
		<div class="hp"><?php echo $card->getHP(); ?></div>
		<div class="magic"><?php echo ($card->getEP()) ? $card->getEP() : '-'; ?></div>
	<?php endif; ?>
</li>