<div id="user-top-details">
	<div id="user-gold" class="user-gold" data-amount="<?php echo $csp_user->getGold(); ?>">
		<div id="user-gold-amount" class="gold"><?php echo $csp_user->getGold(); ?></div>
		<img src="/images/gold.png">
	</div>
	<div id="user-xp" class="user-xp" data-xp="<?php echo $csp_user->getXp(); ?>">
		<div id="user-xp-amount"><?php echo $csp_user->getXp(); ?></div>
		<abbr title="eXperience Points">XP</abbr>
	</div>
	<div id="user-level" class="user-level" data-level="<?php echo $csp_user->getLevel(); ?>">
		<div id="user-level-amount"><?php echo $csp_user->getLevel(); ?></div>
		<abbr title="Character level">lvl</abbr>
	</div>
</div>
<script>
	Devo._user_gold = <?php echo $csp_user->getGold(); ?>;
	Devo._user_xp = <?php echo $csp_user->getXp(); ?>;
	Devo._user_level = <?php echo $csp_user->getLevel(); ?>;
</script>