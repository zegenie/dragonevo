<h1>Changelog</h1>
<h3>Latest version: <?php echo $csp_response->getVersion(); ?> (alpha)</h3>
<h6>0.4.502</h6>
<ul>
	<li>You can now use cards in as many games as you want</li>
	<li>Attacks will now only use one item card unless it requires two</li>
	<li>You can only equip one attack item (staff, spear, sword, bow, arrow) and one defensive item (armor or shield) unless more is required by card attacks</li>
	<li>Attacks will now no longer apply seemingly random effects after attacks</li>
	<li>When picking cards you can no longer go over the max card(s) limit</li>
</ul>
<h6>0.4.430</h6>
<ul>
	<li>Show card level on player-owned cards</li>
	<li>Don't apply effects on a card in-game if there's already an active effect of the same type</li>
</ul>
<h6>0.4.421</h6>
<ul>
	<li>Added gameplay tutorial to help users pick cards and play the game</li>
	<li>Other bugfixes</li>
</ul>
<h6>0.4.411</h6>
<ul>
	<li><strong>Due to a bug in the matchmaking backend, all games have been reset</strong></li>
	<li>Cards can now be moved back to the hand while unplaced, and moving cards in general is more safe</li>
	<li>Better card sorting in "My cards"</li>
	<li>The AI will no longer play a card that has been killed from card effects during the replenishment phase</li>
	<li>Heaps of improvements to the adventure map and adventure book layout, positioning and movement</li>
	<li>You can now zoom the adventure map</li>
	<li>The adventure map will now properly filter adventures and stories per faction and type</li>
	<li>The adventure map will now only show adventures and stories you have cards for</li>
	<li>Other bugfixes</li>
</ul>
<h6>0.4.261</h6>
<ul>
	<li>NEW: Adventure mode alpha test for selected users</li>
	<li>NEW: Added a couple in-game tutorials</li>
	<li>NEW: Use "/me" in chat for actions</li>
	<li>Several stability and bugfixes</li>
</ul>
<h6>0.4.183</h6>
<ul>
	<li>NEW: You can now use XP to level up your character, enabling new attacks and abilities</li>
	<li>NEW: You can now use XP to level up your card, its attacks or both</li>
	<li>NEW: You can now use XP to train skills</li>
	<li>Reimplemented XP cost for use when training skills and levelling up</li>
	<li>Fixed upgrading cards logic</li>
	<li>RESET: All trained skills have been reset</li>
	<li>RESET: All user's level and XP has been reset now that XP has been implemented properly. All users have gotten 750 XP to play with during this test.</li>
</ul>
<h6>0.4.77</h6>
<ul>
	<li>Added more information to game list tooltip, as well as improved tooltip positioning</li>
	<li>Added "Players online" header to lobby left hand side</li>
	<li>Moved game invitations into new list in lobby</li>
	<li>Layout improvements in lobby game list</li>
</ul>
<h6>0.4.62</h6>
<ul>
	<li>You can now choose to level up cards when your character reaches the next level</li>
	<li>Fix loading screen disappearing too fast in many cases</li>
	<li>Fix a few card display issues</li>
</ul>
<h6>0.4.23</h6>
<ul>
	<li>Item cards can now cause an effect if used in conjunction with an attack that doesn't cause an effect (f.ex. fire arrow can cause a fire effect if used with a ranged attack)</li>
	<li>Item cards will now properly improve the chance of an attack's corresponding effect being caused (f.ex. fire arrow improving chance of causing fire effect when used in a fire attack)</li>
	<li>Improve card attack tooltip visibility</li>
	<li>Added card attack bonus indicator for item bonuses</li>
	<li>Card forage / steal now has its own attack icon instead of showing melee</li>
	<li>Several in-game card display tweaks and improvements</li>
</ul>
<h6>0.4.1</h6>
<ul>
	<li>Improved reliability and toned down damage spread for "attack all cards"-attacks to prevent wipeouts</li>
	<li>Fixed so that melee and ranged attacks with stun chance actually can stun</li>
	<li>Display stun chance in attack damage tooltip</li>
</ul>
<h6>0.4.0</h6>
<ul>
	<li>Potions have been (re-)introduced</li>
	<li>New "Potions" button in the top button-menu, instead of "Events"</li>
	<li>"Events" button has been renamed "Game events" and is placed in the bottom menu</li>
	<li>Opponent's gold is now displayed in game</li>
	<li>Player's gold is now displayed <b>to the left</b></li>
	<li>Opponents attacks are now shown as disabled if unavailable</li>
	<li>Attacks that steal gold are now calculated more correctly according to the stats</li>
	<li>Attacks must now be enabled with the correct item card type if required</li>
	<li>Attacks can now be character level-dependant</li>
	<li>Attacks now target gold piles instead of cards when mining or stealing</li>
	<li>Improved display for steal and mine attacks</li>
	<li>Attacks now show required character level inline and in tooltip</li>
	<li>Attacks now show required equippable item card(s) in tooltip</li>
	<li>Cards are now positioned correctly in attack area</li>
</ul>
<h6>0.3.5</h6>
<ul>
	<li>Improved skill display for skill bonuses and penalties</li>
	<li>Allow picking "world" cards as part of game deck</li>
	<li>Added desync screen if desyncs occur</li>
	<li>Database backend improvements</li>
	<li>Fixed skills bonuses and penalties calculation</li>
	<li>Fixed a bug that caused the "end turn" timer to not trigger</li>
	<li>Fixed a bug that caused the AI to put dead cards back in play after they were killed</li>
	<li>Fixed so that the lobby loads when you click "back to lobby" after a game ends</li>
	<li>Fixed display name in end game screen</li>
	<li>Fixed so cards do not receive negative HP when modifier effects occur</li>
	<li>Fixed a bug that caused the first card tile to not be selectable when placing cards</li>
	<li>Fixed a bug that caused the event playback poller to not reset in-between games</li>
	<li>Fixed a bug that caused the main pollers to not destruct properly</li>
</ul>
<h6>0.3.0</h6>
<ul>
	<li>NEW: Game UI</li>
	<li>NEW: Chat UI</li>
	<li>A couple bugfixes</li>
</ul>
<h6>0.2.6.27</h6>
<ul>
	<li>You will now be notified when you're invited to a game (if you're not online)</li>
	<li>You will now be notified if it's your turn in a game (if you're not online)</li>
	<li>Several minor bugfixes</li>
</ul>
<h6>0.2.6.0</h6>
<ul>
	<li>NEW: Improved navigation with support for back / forward buttons</li>
	<li>NEW: Board style is now a user setting (2D or 3D) in settings</li>
</ul>
<h6>0.2.5.74</h6>
<ul>
	<li>Removed drag / drop auto detection</li>
	<li>NEW: Move card style setting in settings</li>
	<li>Fixed a bug that caused cards to stack up next to eachother during attack view</li>
	<li>Improved styling of "flee battle?" dialog</li>
</ul>
<h6>0.2.5.8</h6>
<ul>
	<li>Properly detect drag and drop support via Modernizr</li>
</ul>
<h6>0.2.5.0</h6>
<ul>
	<li>NEW: Can now move cards on devices with non-touch-screens</li>
	<li>NEW: Improved card picker on low-resolution devices (mobile, pad, tab, etc)</li>
	<li>A couple of in-game bug fixes</li>
	<li>Made the chat poller backend a little less naggy</li>
	<li>A bunch of tweaks</li>
</ul>
<h6>0.2.4.42</h6>
<ul>
	<li>NEW: Skills trained when levelling up now applies during games</li>
	<li>NEW: Card selection now follows game rules for number of chosen cards (Creature: min 3/ max 13, Item: min 2/ max 8)</li>
	<li>NEW: Display skill modifiers in the skill overview</li>
	<li>NEW: Game chat is now available during card selection</li>
	<li>A few in-game bug fixes</li>
</ul>
<h6>0.2.4.0</h6>
<ul>
	<li>NEW: Market, including misc. navigation links to and from the market</li>
	<li>Support buying new cards with in-game gold</li>
	<li>Several minor in-game bug fixes to improve game flow</li>
</ul>
<h6>0.2.3.0</h6>
<ul>
	<li>Add support for mobile and low-resolution devices, except in-game</li>
</ul>
<h6>0.2.2.83</h6>
<ul>
	<li>Better shelf "repeat" blend</li>
	<li>Improved visual effects</li>
	<li>Fixed opponents cards stacking up in the attack area with repeat damage</li>
</ul>
<h6>0.2.2.61</h6>
<ul>
	<li>Added new "sword clash" battle effect</li>
	<li>Fixed a backend error with effects</li>
</ul>
<h6>0.2.2.47</h6>
<ul>
	<li>Improve login accuracy on touch devices</li>
	<li>Fixed admin tool not properly resetting all user cards in certain cases</li>
	<li>Added more details to admin user tool</li>
</ul>
<h6>0.2.2.29</h6>
<ul>
	<li>Fixed a couple of minor bugs with the chat</li>
	<li>Fixed the chat bubble only popping up when the chat was already in focus</li>
	<li>Fixed initial deck picking the wrong deck in 2 out of 3 cases</li>
</ul>
<h6>0.2.2.25</h6>
<ul>
	<li>Added card type filter to profile shelf view and game card picker shelf view</li>
	<li>Added picked card counters for all card types to game card picker view</li>
</ul>
<h6>0.2.2.1</h6>
<ul>
	<li>Some admin fixes</li>
	<li>Added possibility to completely reset a users character info (trained skills, character, avatar, level, etc)</li>
</ul>
<h6>0.2.2</h6>
<ul>
	<li>Removed game chat from top auto-dropdown</li>
	<li>Game chat is now available as a separate menu bar tab when in-game, similar to lobby</li>
</ul>
<h6>0.2.1.8</h6>
<ul>
	<li>Fixed a couple of issues with a persistent loading screen</li>
</ul>
<h6>0.2.1.0</h6>
<ul>
	<li>Added avatar selection during profile setup</li>
	<li>Implemented avatar display in lobby chat</li>
	<li>Implemented proper avatar display in game opponent view</li>
</ul>
<h6>0.2.0.13</h6>
<ul>
	<li>Fixed a bug where the music did not stop playing when ending a game</li>
	<li>Fixed a bug with game invitations not working properly</li>
</ul>
<h6>0.2.0</h6>
<ul>
	<li>Rewrote entire game UI</li>
	<li>Tons of bugfixes and improvements</li>
	<li>Speedup!</li>
</ul>
<h6>0.1.5.115</h6>
<ul>
	<li>Fixed login issues with or without www.</li>
	<li>Added public changelog</li>
</ul>
<h6>0.1.5.105</h6>
<ul>
	<li>Added lobby chat indicator when in-match</li>
</ul>
<h6>0.1.5.100</h6>
<ul>
	<li>Added new in-match UI</li>
	<li>Made lobby available in-match</li>
	<li>Tons of in-match bugfixes</li>
</ul>
<h6>0.1.5.0</h6>
<ul>
	<li>Introduced new game board 3D rendering mode</li>
	<li>Introduced new battle player with battling cards in focus</li>
	<li>Added new game menu</li>
	<li>Added "Play now" button</li>
	<li>Added new lobby UI and game info bar</li>
	<li>Fixed training mode</li>
</ul>
<h6>0.1.4.30</h6>
<ul>
	<li>Added player skills</li>
	<li>Added support for levelling up characters and spending XP</li>
</ul>