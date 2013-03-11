<div id="<?php echo $tellable->getTellableType(); ?>-<?php echo $tellable->getId(); ?>-map-point"
	class="map-point <?php echo $tellable->getTellableType(); ?> <?php if ($tellable->getTellableType() == \application\entities\Tellable::TYPE_PART && !$tellable->isAvailableForUser($completed_items)) echo ' unavailable'; ?> <?php if ($tellable->getTellableType() != \application\entities\Tellable::TYPE_ADVENTURE && $tellable->isCompletedForUser($completed_items)) echo ' completed'; ?> <?php if ($tellable->doesApplyToResistance()) echo ' applies-resistance'; ?><?php if ($tellable->doesApplyToNeutrals()) echo ' applies-neutrals'; ?><?php if ($tellable->doesApplyToRutai()) echo ' applies-rutai'; ?>"
	<?php if ($tellable->getTellableType() != \application\entities\Tellable::TYPE_CHAPTER): ?>
		style="left: <?php echo $tellable->getCoordinateX(); ?>px; top: <?php echo $tellable->getCoordinateY(); ?>px;"
	<?php endif; ?>
	data-fullstory="<?php echo nl2br(htmlspecialchars($tellable->getFullstory())); ?>"
	data-title="<?php echo htmlspecialchars($tellable->getName()); ?>"
	data-excerpt="<?php echo htmlspecialchars($tellable->getExcerpt()); ?>"
	data-reward-gold="<?php echo $tellable->getRewardGold(); ?>"
	data-reward-xp="<?php echo $tellable->getRewardXp(); ?>"
	data-tellable-id="<?php echo $tellable->getId(); ?>"
	data-tellable-type="<?php echo $tellable->getTellableType(); ?>"
	data-required-level="<?php echo $tellable->getRequiredLevel(); ?>"
	<?php if (in_array($tellable->getTellableType(), array(\application\entities\Tellable::TYPE_PART, \application\entities\Tellable::TYPE_CHAPTER))): ?>
		data-parent-id="<?php echo $tellable->getParentId(); ?>"
		data-parent-type="<?php echo $tellable->getParentType(); ?>"
	<?php endif; ?>
	<?php if ($tellable->hasCardRewards()): ?>
		data-card-rewards
	<?php endif; ?>
	<?php if (!$tellable->isVisibleForUser($csp_user)): ?>
		data-not-visible
	<?php endif; ?>
	<?php if ($tellable->doesApplyToResistance()): ?>
		data-applies-resistance
	<?php endif; ?>
	<?php if ($tellable->doesApplyToNeutrals()): ?>
		data-applies-neutrals
	<?php endif; ?>
	<?php if ($tellable->doesApplyToRutai()): ?>
		data-applies-rutai
	<?php endif; ?>
	<?php if ($tellable->getTellableType() == \application\entities\Tellable::TYPE_PART): ?>
		data-coord-x="<?php echo $tellable->getCoordinateX(); ?>"
		data-coord-y="<?php echo $tellable->getCoordinateY(); ?>"
		<?php if ($tellable->getRequiredLevel() > $csp_user->getLevel() || !$tellable->isAvailableForUser($completed_items)): ?>
			data-unavailable
		<?php endif; ?>
		<?php if ($tellable->getTellableType() == \application\entities\Tellable::TYPE_PART && $tellable->hasCardOpponents()): ?>
			data-card-opponents
		<?php endif; ?>
	<?php endif; ?>
	></div>
<script>$('<?php echo $tellable->getTellableType(); ?>-<?php echo $tellable->getId(); ?>-map-point').observe('click', Devo.Main.select<?php echo ucfirst($tellable->getTellableType()); ?>);</script>