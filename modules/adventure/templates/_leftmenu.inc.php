<div class="content left" id="left-menu-container">
	<h1>Available quests</h1>
	<div id="available-quests-lists-none-story" class="no-quests-lists" style="display: none;">There are no available stories</div>
	<div id="available-quests-lists-none-adventure" class="no-quests-lists" style="display: none;">There are no available stories</div>
	<ul id="available-quests-list">
		<?php foreach ($stories as $story): ?>
			<?php if ($story->isVisibleForUser($csp_user)): ?>
				<li id="story-<?php echo $story->getId(); ?>" class="quest story <?php if ($story->doesApplyToResistance()) echo ' applies-resistance'; ?><?php if ($story->doesApplyToNeutrals()) echo ' applies-neutrals'; ?><?php if ($story->doesApplyToRutai()) echo ' applies-rutai'; ?>"
					data-story-id="<?php echo $story->getId(); ?>"
					data-tellable-id="<?php echo $story->getId(); ?>"
					data-coord-x="<?php echo $story->getCoordinateX(); ?>"
					data-coord-y="<?php echo $story->getCoordinateY(); ?>"
					<?php if ($story->doesApplyToResistance()): ?>
						data-applies-resistance
					<?php endif; ?>
					<?php if ($story->doesApplyToNeutrals()): ?>
						data-applies-neutrals
					<?php endif; ?>
					<?php if ($story->doesApplyToRutai()): ?>
						data-applies-rutai
					<?php endif; ?>
					data-tellable-type="story"
					style="display: none;"
					>
					<h4><?php echo $story->getName(); ?></h4>
					<div class="tellable-details">
						<?php echo count($story->getChapters()); ?> chapters (<?php echo $story->getPercentCompleted($completed_items); ?>% completed)<br>
						<?php if ($story->getRewardGold()): ?>
							<div class="reward gold-reward"><img src="/images/coin_small.png"><span class="gold"><?php echo $story->getRewardGold(); ?></span></div>
						<?php endif; ?>
						<?php if ($story->getRewardXp()): ?>
							<div class="reward xp-reward"><?php echo $story->getRewardXp(); ?>XP</div>
						<?php endif; ?>
						<?php if ($story->hasCardRewards()): ?>
							<div class="reward cards"><?php echo count($story->getCardRewards()); ?> card(s)</div>
						<?php endif; ?>
						<?php if ($story->getRequiredLevel() > 1): ?>
							<br>
							<div class="requires-level">Minimum level <?php echo $story->getRequiredLevel(); ?></div>
						<?php endif; ?>
					</div>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php foreach ($adventures as $adventure): ?>
			<?php if ($adventure->isVisibleForUser($csp_user)): ?>
				<li id="adventure-<?php echo $adventure->getId(); ?>" class="quest adventure <?php if ($adventure->doesApplyToResistance()) echo ' applies-resistance'; ?><?php if ($adventure->doesApplyToNeutrals()) echo ' applies-neutrals'; ?><?php if ($adventure->doesApplyToRutai()) echo ' applies-rutai'; ?>"
					data-adventure-id="<?php echo $adventure->getId(); ?>"
					data-coord-x="<?php echo $adventure->getCoordinateX(); ?>"
					data-coord-y="<?php echo $adventure->getCoordinateY(); ?>"
					data-tellable-id="<?php echo $adventure->getId(); ?>"
					<?php if ($adventure->doesApplyToResistance()): ?>
						data-applies-resistance
					<?php endif; ?>
					<?php if ($adventure->doesApplyToNeutrals()): ?>
						data-applies-neutrals
					<?php endif; ?>
					<?php if ($adventure->doesApplyToRutai()): ?>
						data-applies-rutai
					<?php endif; ?>
					data-tellable-type="adventure"
					style="display: none;"
					>
					<h4><?php echo $adventure->getName(); ?></h4>
					<div class="tellable-details">
						<?php if ($adventure->getRewardGold()): ?>
							<div class="reward gold-reward"><img src="/images/coin_small.png"><span class="gold"><?php echo $adventure->getRewardGold(); ?></span></div>
						<?php endif; ?>
						<?php if ($adventure->getRewardXp()): ?>
							<div class="reward xp-reward"><?php echo $adventure->getRewardXp(); ?>XP</div>
						<?php endif; ?>
						<?php if ($adventure->hasCardRewards()): ?>
							<div class="reward cards"><?php echo count($adventure->getCardRewards()); ?> card(s)</div>
						<?php endif; ?>
						<?php if ($adventure->getRequiredLevel() > 1): ?>
							<br>
							<div class="requires-level">Minimum level <?php echo $adventure->getRequiredLevel(); ?></div>
						<?php endif; ?>
					</div>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
<script>
	<?php foreach ($stories as $story): ?>
		<?php if (!$story->isVisibleForUser($csp_user)) continue; ?>
		$('story-<?php echo $story->getId(); ?>').observe('click', Devo.Main.highlightTellable);
	<?php endforeach; ?>
	<?php foreach ($adventures as $adventure): ?>
		<?php if (!$adventure->isVisibleForUser($csp_user)) continue; ?>
		$('adventure-<?php echo $adventure->getId(); ?>').observe('click', Devo.Main.highlightTellable);
	<?php endforeach; ?>
</script>
