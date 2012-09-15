<?php if ($card instanceof application\entities\PotionItemCard): ?>
	<div class="attack potion" data-attack-id="attack_<?php echo $card->getUniqueId(); ?>" data-remaining-uses="<?php echo $card->getNumberOfUses(); ?>" id="attack_<?php echo $card->getUniqueId(); ?>">
		<div class="attack_name">Use potion</div>
		<?php if ($card->doesRestoreHealth()): ?>
			<div class="attack_impact health">Restores <?php echo "{$card->getRestoresHealthPercentage()}% HP"; ?></div>
		<?php elseif ($card->doesRestoreEnergy()): ?>
			<div class="attack_impact energy">Restores <?php echo "{$card->getRestoresEnergyPercentage()}% EP"; ?></div>
		<?php else: ?>
			<?php foreach(array('Air', 'Dark', 'Fire', 'Freeze', 'Poison', 'Stun') as $type): ?>
				<?php $removesEffect = 'doesRemove'.$type; ?>
				<?php if ($card->$removesEffect()): ?>
					<div class="attack_impact remove-effect">Removes <?php echo image_tag('/images/attack_'.strtolower($type).'.png') . '&nbsp;' . $type; ?> effect</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="tooltip attack_details">
			<div class="attack_name">Use potion</div>
			<div class="attack_description">
				Use this potion one time. If there are no remaining uses after the potion is spent, it will be removed from the game.<br>
				<br>
				<?php if ($card->isOneTimePotion()): ?>
					<div class="attack_unblockable">This is a one-time potion. If you use it in this game, it will be removed from your deck after the game ends.</div>
				<?php endif; ?>
				<div class="restore_health"<?php if (!$card->getRestoresHealthPercentage()): ?> style="display: none;"<?php endif; ?>>Restores <?php echo $card->getRestoresHealthPercentage(); ?>% HP</div>
				<div class="restore_ep"<?php if (!$card->getRestoresEnergyPercentage()): ?> style="display: none;"<?php endif; ?>>Restores <?php echo $card->getRestoresEnergyPercentage(); ?>% EP</div>
			</div>
		</div>
	</div>
<?php endif; ?>