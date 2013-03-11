<li id="card_opponent_<?php echo $opponent->getId(); ?>">
	<a href="javascript:void(0);" onclick="Devo.Admin.removeCardOpponent(<?php echo $opponent->getId(); ?>)" class="button button-standard" style="font-size: 0.9em; margin-right: 5px;"><img src="/images/spinning_16.gif" style="display: none;">Remove</a>
	<span class="card_name <?php if ($opponent->getCard() instanceof application\entities\CreatureCard) echo $opponent->getCard()->getFaction(); ?>"><?php echo $opponent->getCard()->getName(); ?> 
		<?php if ($opponent->getCard() instanceof application\entities\CreatureCard): ?>(<?php echo ($opponent->getCardLevel() > 0) ? 'level '.$opponent->getCardLevel() : 'User level'; ?>)<?php endif; ?>
		<?php if ($opponent->getCard() instanceof application\entities\PotionItemCard): ?>(potion)<?php endif; ?>
		<?php if ($opponent->getCard() instanceof application\entities\EquippableItemCard): ?>(item)<?php endif; ?>
	</span>
</li>