<div class="adventure-menu-bar" id="adventure-menu-bar">
	<div class="button-group filters" id="adventure-menu-bar-buttons">
		<button class="button button-silver" data-selected-filter="rutai" id="quest-category-button" onclick="Devo.Main.Helpers.popup(this);">Selected faction: Rutai <span>&#9660;</span></button>
		<div class="popup-menu" id="quest-category-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<?php foreach ($factions as $faction => $description): ?>
					<?php if ($faction == application\entities\Card::FACTION_WORLD || !$csp_user->hasCardsInFaction($faction)) continue; ?>
					<li><a href="javascript:void(0);" data-filter="<?php echo $faction; ?>" onclick="Devo.Main.filterQuests('<?php echo $faction; ?>');"><?php echo $description; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<button class="button button-silver last" id="quest-type-button" onclick="Devo.Main.Helpers.popup(this);" data-selected-filter="story">Quest type: Stories<span>&#9660;</span></button>
		<div class="popup-menu" id="quest-type-popup" style="left: 0; right: auto; width: 350px; z-index: 10;">
			<ul>
				<li><a href="javascript:void(0);" data-filter="story" onclick="Devo.Main.filterQuestType('story');">Stories</a></li>
				<li><a href="javascript:void(0);" data-filter="adventure" onclick="Devo.Main.filterQuestType('adventure');">Adventures</a></li>
			</ul>
		</div>
	</div>
	<div class="button-group zoom">
		<button class="button button-silver" onclick="Devo.Main.mapZoomOut();"><img src="/images/zoom_out.png"></button>
		<button class="button button-silver" onclick="Devo.Main.mapZoomIn();"><img src="/images/zoom_in.png"></button>
	</div>
</div>
