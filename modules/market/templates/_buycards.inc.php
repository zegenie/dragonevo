<ul>
	<?php foreach ($allcards as $cards): ?>
		<?php foreach ($cards as $card): ?>
			<li style="display: none;">
				<div onclick="Devo.Main.showCardDetails('<?php echo $card->getUniqueId(); ?>');" style="cursor: pointer;">
					<?php include_template('game/card', array('card' => $card, 'mode' => 'medium', 'ingame' => false)); ?>
				</div>
				<?php include_template('main/carddetails', compact('card')); ?>
			</li>
		<?php endforeach; ?>
	<?php endforeach; ?>
</ul>
