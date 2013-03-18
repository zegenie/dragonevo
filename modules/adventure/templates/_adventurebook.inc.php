<div id="adventure-book" style="display: none;">
	<div class="bookmark-flips back" id="bookmark-flips-back">
	</div>
	<div class="bookmark-flips" id="bookmark-flips">
		<div class="bookmark-flip selected" id="page-1-flip" onclick="Devo.Main.selecteAdventurePage('page-1', this);">Summary</div>
		<div class="bookmark-flip" onclick="Devo.Main.selecteAdventurePage('tellable-rewards', this);">Rewards &amp; attempts</div>
	</div>
	<div class="page-flip selected" id="page-1">
		<div class="tellable-page page-left">
			<h2 id="tellable-header"></h2>
			<div id="tellable-fullstory"></div>
		</div>
		<div class="tellable-page page-right">
			<div id="tellable-children">
				<h2 id="tellable-chapters">Chapters</h2>
				<h2 id="tellable-parts">Quests</h2>
				<div id="tellable-children-list"></div>
			</div>
			<div id="tellable-card-opponents">
				<h2>Facing off against</h2>
				<div id="tellable-card-opponent-cards"></div>
				<div id="tellable-card-opponent-cards-none">Select one of the quests to see which cards you will be facing</div>
			</div>
		</div>
	</div>
	<div id="tellable-rewards" class="page-flip">
		<div class="tellable-page page-left" id="tellable-rewards-list">
			<h2>Rewards</h2>
			<div class="reward gold-reward" id="tellable-gold-reward"><img src="/images/coin_small.png"><span class="gold"></span></div>
			<div class="reward xp-reward" id="tellable-xp-reward"><span></span>XP</div>
			<div>If you complete this <span class="tellable-reward-tellable-type">quest</span>, you will receive the above reward(s).</div>
			<div id="tellable-card-rewards">
				<h2>Additional rewards</h2>
				<div id="tellable-card-reward-cards"></div>
				<div>If you complete this <span class="tellable-reward-tellable-type">quest</span>, you will also receive the above card(s).</div>
			</div>
		</div>
		<div class="tellable-page page-right">
			<div id="tellable-attempts">
				<h2>Previous attempts at this <span class="tellable-reward-tellable-type">quest</span></h2>
				<div id="tellable-attempts-list"></div>
				<div id="tellable-no-attempts">You have never attempted this <span class="tellable-reward-tellable-type">quest</span> before</div>
			</div>
			<div class="play-buttons" id="tellable-play-buttons">
				<span id="story-explanation">To earn these rewards, complete all chapters in this story</span>
				<span id="chapter-explanation">To earn these rewards, complete all quests in this chapter</span>
				<span id="adventure-explanation">To earn these rewards, complete all quests in this adventure</span>
				<span id="tellable-level-too-low" style="display: none;">You need to be at least level <span id="tellable-required-level"></span> before attempting this quest</span>
				<span id="tellable-unavailable-message" style="display: none;">Quest requirements not met</span>
				<button class="ui_button" id="start-tellable-button">Start quest</button>
			</div>
		</div>
	</div>
	<div class="page-shadow"></div>
</div>
