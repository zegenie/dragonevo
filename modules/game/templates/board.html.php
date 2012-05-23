<?php $csp_response->setTitle('Game board ~ game '.$game->getName()); ?>
<div id="game-table">
	<div id="opponent-slots-container" class="card-slots-container">
		<ul id="opponent-slots" class="card-slots">
			<li id="opponent-slot-1" class="card-slot"></li>
			<li id="opponent-slot-2" class="card-slot"></li>
			<li id="opponent-slot-3" class="card-slot"></li>
			<li id="opponent-slot-4" class="card-slot"></li>
			<li id="opponent-slot-5" class="card-slot"></li>
		</ul>
	</div>
	<div id="play-area">
		<div id="event-slot" class="card-slot"></div>
	</div>
	<div id="player-slots-container" class="card-slots-container">
		<ul id="player-slots" class="card-slots">
			<li id="player-slot-1" class="card-slot"></li>
			<li id="player-slot-2" class="card-slot"></li>
			<li id="player-slot-3" class="card-slot"></li>
			<li id="player-slot-4" class="card-slot"></li>
			<li id="player-slot-5" class="card-slot"></li>
		</ul>
	</div>
</div>
<div class="tab_menu" id="play-tabs">
	<ul id="play-tabs-menu">
		<?php if ($include_hand): ?>
			<li id="tab-cards"><a href="#">My hand</a></li>
		<?php endif; ?>
	</ul>
</div>
<?php if ($include_hand): ?>
	<?php include_component('game/playerhand', compact('game')); ?>
<?php endif; ?>