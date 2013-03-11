<div class="info-popup <?php echo $tellable->getTellableType(); ?>" style="left: <?php echo $tellable->getCoordinateX(); ?>px; top: <?php echo $tellable->getCoordinateY(); ?>px;">
	<h6><?php echo $tellable->getName(); ?></h6>
	<p>
		<?php echo $tellable->getExcerpt(); ?>
	</p>
	<fieldset>
		<legend>Requirements</legend>
	</fieldset>
	<?php if ($tellable->getTellableType() == \application\entities\Tellable::TYPE_PART): ?>
		<div class="tellable-unavailable">You must finish the previous quest</div>
	<?php endif; ?>
	<div class="requires-level">Minimum level <?php echo $tellable->getRequiredLevel(); ?></div>
	<fieldset>
		<legend>Rewards</legend>
	</fieldset>
	<?php if ($tellable->getRewardGold()): ?>
		<div class="reward gold-reward"><img src="/images/coin_small.png"><span class="gold"><?php echo $tellable->getRewardGold(); ?></span></div>
	<?php endif; ?>
	<?php if ($tellable->getRewardXp()): ?>
		<div class="reward xp-reward"><?php echo $tellable->getRewardXp(); ?>XP</div>
	<?php endif; ?>
	<?php if ($tellable->hasCardRewards()): ?>
		<div class="reward cards"><?php echo count($tellable->getCardRewards()); ?> card(s)</div>
	<?php endif; ?>
</div>
