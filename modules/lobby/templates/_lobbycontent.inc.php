<div class="content" id="lobby-container">
	<div class="lobby_game_actions" id="lobby-game-actions">
		<h3>Players online:<div id="players_online_count"><?php echo $num_users; ?></div></h3>
		<br>
		<?php include_component('main/mygames'); ?>
	</div>
</div>
<?php if ($csp_user->isLobbyTutorialEnabled()): ?>
	<script>
		Devo.Tutorial.Stories.lobby = {
			1: {
				message: '<h1>Welcome to the lobby</h1>This is the main location to set up and find multiplayer games.<br><br>From the lobby, you can invite other players for a quick game, challenge random opponents or just have a talk with likeminded.',
				messageSize: 'large',
				button: 'Got it!'
			},
			2: {
				highlight: {element: 'lobby-game-actions', blocked: true},
				message: '<h3>Lobby overview</h3>This is the lobby information overview. As well as showing how many players are online right now, this is also where any ongoing multiplayer games will be shown.<br><br>If anyone invites you, the invitation will appear in the "Game invites" list. Keep an eye out for invites!',
				messageSize: 'large',
				messagePosition: 'right',
				button: "Where's that again?"
			},
			3: {
				highlight: {element: 'my_invitations_container', blocked: true},
				message: "<h4>My game invitations</h4>It's right here.",
				messageSize: 'small',
				messagePosition: 'right',
				button: 'Of course it is'
			},
			4: {
				highlight: {element: 'chat_room_1_users', blocked: true},
				message: '<h3>Other players</h3>To the right here are all the other players currently connected to the lobby.<br><br>You can invite anyone to play with you by clicking their name and clicking "Challenge!". The invitation will then be sent to that user, and you can see the status ...... ',
				messageSize: 'large',
				messagePosition: 'left',
				button: '... where, where?'
			},
			5: {
				highlight: {element: 'my_ongoing_games_container', blocked: true},
				message: '.... here.',
				messageSize: 'small',
				messagePosition: 'right',
				button: 'Ah, right'
			},
			6: {
				highlight: {element: 'profile_menu_strip', blocked: true},
				message: "<h4>Menu buttons</h4>We've also put some convenient menu buttons right here for you. They are ....",
				messageSize: 'small',
				messagePosition: 'above',
				button: 'Tell me!'
			},
			7: {
				highlight: {element: 'show-menu-button', blocked: true},
				message: "The main menu button, which brings up the main menu ... ",
				messageSize: 'small',
				messagePosition: 'above',
				button: '... and?'
			},
			8: {
				highlight: {element: 'play-quickmatch-button', blocked: true},
				message: 'The "Play quickmatch" button. Pressing this looks for an opponent for a quick game ... ',
				messageSize: 'small',
				messagePosition: 'above',
				button: '... and?'
			},
			9: {
				highlight: {element: 'chat_1_toggler', blocked: true},
				message: '... and a button to toggle the lobby chat. Clicking this button will bring up the lobby chat, wherever you are.',
				messageSize: 'medium',
				messagePosition: 'above',
				button: "That's convenient!"
			},
			10: {
				highlight: {element: 'main-menu-badge', blocked: true},
				message: 'By the way, you can always bring up the main menu by pressing this big badge.',
				messageSize: 'large',
				messagePosition: 'above',
				button: "It's like you've thought of everything!"
			},
			11: {
				message: "<h1>Have fun!</h1>That was it.<br><br>Don't hesitate to ask someone if you're stuck.",
				messageSize: 'medium',
				button: 'Done!'
			}
		};
		Devo.Tutorial.start('lobby');
	</script>
<?php endif; ?>

