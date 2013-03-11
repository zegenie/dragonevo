<div style="overflow: hidden;">
	<?php include_template('adventure/leftmenu', compact('stories', 'adventures', 'completed_items')); ?>
	<?php include_template('adventure/adventurebook'); ?>
	<div class="fullpage_backdrop" id="adventure-start-container" style="display: none;">
		<div class="tutorial-message large full">
			<h4 id="adventure-start-title"></h4>
			<div id="adventure-start-fullstory"></div>
			<h6>Select difficulty</h6>
			<form id="adventure-start-form" onsubmit="Devo.Game.startTellable();return false;">
				<?php foreach (array(application\entities\User::AI_EASY => 'Easy', application\entities\User::AI_NORMAL => 'Normal', application\entities\User::AI_HARD => 'Challenging') as $difficulty => $description): ?>
					<div style="display: inline-block;">
						<input type="radio" name="difficulty" id="adventure-difficulty-<?php echo $difficulty; ?>" value="<?php echo $difficulty; ?>" style="float: left;" <?php if ($difficulty == application\entities\User::AI_NORMAL) echo ' checked'; ?>>
						<label for="adventure-difficulty-<?php echo $difficulty; ?>" style="float: none; display: inline-block; min-width: 100px; text-align: left; padding: 7px 0;"><?php echo $description; ?></label>
					</div>
				<?php endforeach; ?>
				<br style="clear: both;">
				<input type="submit" class="button button-standard" value="Start quest" id="adventure-start-tellable-button">
			</form>
		</div>
	</div>
	<div class="content adventure" id="adventure-container">
		<div id="adventure-map" draggable="false">
			<?php include_component('adventure/menubar'); ?>
			<div class="border stretch top"></div>
			<div class="border stretch left"></div>
			<div class="border stretch right"></div>
			<div class="border stretch bottom"></div>
			<div id="adventure-map-image" data-zoom-level="3" class="zoom-level-3" data-coord-x="0" data-coord-y="0">
				<?php foreach ($stories as $story): ?>
					<?php if ($story->isVisibleForUser($csp_user)): ?>
						<div id="story-<?php echo $story->getId(); ?>-map-points-container" class="map-point-container story <?php if ($story->doesApplyToResistance()) echo ' applies-resistance'; ?><?php if ($story->doesApplyToNeutrals()) echo ' applies-neutrals'; ?><?php if ($story->doesApplyToRutai()) echo ' applies-rutai'; ?>" data-tellable-type="story" style="display: none;">
							<?php include_template('adventure/mappoint', array('tellable' => $story, 'completed_items' => $completed_items)); ?>
							<?php include_template('adventure/infopopup', array('tellable' => $story)); ?>
							<?php foreach ($story->getChapters() as $chapter): ?>
								<?php include_template('adventure/mappoint', array('tellable' => $chapter, 'completed_items' => $completed_items)); ?>
								<?php include_template('adventure/infopopup', array('tellable' => $chapter)); ?>
								<?php foreach ($chapter->getParts() as $part): ?>
									<?php include_template('adventure/mappoint', array('tellable' => $part, 'completed_items' => $completed_items)); ?>
									<?php include_template('adventure/infopopup', array('tellable' => $part)); ?>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php foreach ($adventures as $adventure): ?>
					<?php if ($adventure->isVisibleForUser($csp_user)): ?>
					<div id="adventure-<?php echo $adventure->getId(); ?>-map-points-container" class="map-point-container adventure <?php if ($adventure->doesApplyToResistance()) echo ' applies-resistance'; ?><?php if ($adventure->doesApplyToNeutrals()) echo ' applies-neutrals'; ?><?php if ($adventure->doesApplyToRutai()) echo ' applies-rutai'; ?>" data-tellable-type="adventure" style="display: none;">
						<?php include_template('adventure/mappoint', array('tellable' => $adventure)); ?>
						<?php include_template('adventure/infopopup', array('tellable' => $adventure)); ?>
						<?php foreach ($adventure->getParts() as $part): ?>
							<?php include_template('adventure/mappoint', array('tellable' => $part, 'completed_items' => $completed_items)); ?>
							<?php include_template('adventure/infopopup', array('tellable' => $part)); ?>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<img ondrag="return false;" src="/images/worldmap.jpg" draggable="false">
			</div>
		</div>
	</div>
</div>
<script>
    new ImagesObserver('adventure-map-image', {
		onImagesLoaded: function() {
			Devo.Main.Helpers.finishLoading();
			var faction = $('quest-category-popup').down().childElements().last().down().dataset.filter;
			Devo.Main.filterQuests(faction);
			Devo.Main.filterQuestType('story');
			Devo._user_level = <?php echo $csp_user->getLevel(); ?>;
		}
    });

	Devo.Core._mapLocations = {
		<?php echo application\entities\Card::FACTION_NEUTRALS; ?>: {x: -2140, y: -180},
		<?php echo application\entities\Card::FACTION_RESISTANCE; ?>: {x: -400, y: -900},
		<?php echo application\entities\Card::FACTION_RUTAI; ?>: {x: -1415, y: -854}
	}

	$('adventure-map').observe('mousedown', Devo.Main.startMapDrag);
	$('adventure-map').observe('mouseup', Devo.Main.stopMapDrag);
	$('adventure-book').observe('mousedown', Devo.Main.startBookDrag);
	$('adventure-book').observe('mouseup', Devo.Main.stopBookDrag);
	$('adventure-map-image').observe('click', Devo.Main.clearMapSelections);
	$('tellable-fullstory').observe('mousedown', function(e) { e.stopPropagation(); });
	<?php if ($csp_user->isAdventureTutorialEnabled()): ?>
		Devo.Tutorial.Stories.adventure = {
			1: {
				message: "<h1>Adventure mode</h1>Welcome to the adventure mode main map!<br><br>From this map you can start all available single player stories for any faction you have cards.<br><br>Your starter pack should alredy have given you enough cards to get started with one of the faction's storyline.",
				messageSize: 'large',
				button: 'Next'
			},
			2: {
				message: '<h3>Adventure mode</h3>The adventure map consists of several parts: the world map, your quests list, and the adventure book.',
				messageSize: 'medium',
				button: "Tell me more"
			},
			3: {
				highlight: {element: 'adventure-map', blocked: true},
				message: "<h4>The world map</h4>This is the world map. All available quests are shown here.",
				messageSize: 'small',
				messagePosition: 'left',
				button: 'Next'
			},
			4: {
				highlight: {element: 'adventure-menu-bar-buttons', blocked: true},
				message: '<h3>The world map</h3>You can filter which quests are shown using the map filters at the top.<br><br>These filters lets you show available quests for each faction you have cards for, as well as switch between showing longer stories with several sub-quests and smaller, single adventures which can be played over and over.',
				messageSize: 'large',
				messagePosition: 'below',
				button: 'Makes sense'
			},
			5: {
				highlight: {element: 'left-menu-container', blocked: true},
				message: '<h4>Selecting a quest</h4>All available quests are shown on the map as dots, but they are also listed in this list. Clicking an item in this list takes you to the location on the map for that quest.',
				messageSize: 'medium',
				messagePosition: 'right',
				button: 'Can I try?'
			},
			6: {
				highlight: {element: 'available-quests-list', blocked: false},
				message: "<h4>Selecting a quest</h4><br><strong>Select a quest in the list on the left.</strong>",
				messageSize: 'small',
				messagePosition: 'right',
				cb: function(td) {
					$('available-quests-list').childElements().each(function(elm) {
						if (elm.visible()) {
							elm.observe('click', function() {
								$('available-quests-list').childElements().each(function(elm) {
									elm.stopObserving('click');
									elm.observe('click', Devo.Main.highlightTellable);
								});
								Devo.Tutorial.playNextStep();
							});
						}
					});
				}
			},
			7: {
				highlight: {element: 'adventure-map', blocked: false},
				message: "<h4>Selecting a quest</h4>As you can see, the map now moved to the position where the selected quest is located. You can click on the point on the map to bring up more details about the quest.<br><br>Some quests are faded out because they are not available. You can see more details about the quest - including requirements and rewards - by holding your mouse over that map point.<br><br><strong>Click on the point on the map</strong>",
				messageSize: 'small',
				messagePosition: 'left',
				cb: function(td) {
					$('adventure-map').stopObserving('mousedown', Devo.Main.startMapDrag);
					$('adventure-map').observe('mousedown', function(event) { event.stopPropagation(); });
					$$('.map-point').each(function(elm) {
						if (elm.visible()) {
							elm.observe('click', Devo.Tutorial.playNextStep);
						}
					});
				}
			},
			8: {
				highlight: {element: 'adventure-map', blocked: true},
				message: "<h4>Selecting a quest</h4>When you've selected a quest, you can see more details about the quest, such as all the main chapters (if you've selected a story).<br><br>Clicking a chapter lets you see more details about that chapter, as well as start it.",
				messageSize: 'small',
				messagePosition: 'left',
				button: 'Next',
				cb: function(td) {
					$('adventure-map').stopObserving('mousedown');
					$('adventure-map').observe('mousedown', Devo.Main.startMapDrag);
					$$('.map-point').each(function(elm) {
						if (elm.visible()) {
							elm.stopObserving('click', Devo.Tutorial.playNextStep);
							$('tutorial-next-button').stopObserving('click');
							$('tutorial-next-button').observe('click', function() {
								$('adventure-book').show();
								$('tutorial-next-button').stopObserving('click');
								window.setTimeout(function() {
									Devo.Tutorial.playNextStep();
								}, 500);
							});
							$('adventure-book').hide();
						}
					});
				}
			},
			9: {
				highlight: {element: 'adventure-book', blocked: true},
				message: "<h4>Selecting a quest</h4>When you've selected a quest on the map, you will see the adventure book pop up.<br><br>The adventure book has more information about the selected quest with the background story and quest description, as well as more information about its rewards.<br><br>It will also keep track of your attempts at that quest (available later).",
				messageSize: 'large',
				messagePosition: 'above',
				button: "Next",
				cb: function(td) {
					$('tutorial-next-button').stopObserving('click');
					$('tutorial-next-button').observe('click', Devo.Tutorial.playNextStep);
				}
			},
			10: {
				highlight: {element: 'adventure-book', blocked: true},
				message: '<h4>Selecting a quest</h4>The adventure book also has buttons to start the quest if it is available.<br><br>By the way, if the adventure book is in your way, you can always move it by dragging it around.',
				messageSize: 'medium',
				messagePosition: 'above',
				button: "Can I try moving it now?"
			},
			11: {
				highlight: {element: 'adventure-book', blocked: true},
				message: '<h4>Selecting a quest</h4>Not now.',
				messageSize: 'medium',
				messagePosition: 'above',
				button: "Awww ..."
			},
			12: {
				message: "<h1>Have fun!</h1>That was it.<br><br>Don't hesitate to ask someone if you're stuck. Remember, the lobby is always just a click away.",
				messageSize: 'medium',
				button: 'Done!',
				cb: function() {
					Devo.Main.clearMapSelections();
				}
			}
		};
		Devo.Tutorial.start('adventure');
	<?php endif; ?>
</script>