<div class="game_invites" id="game_invites">
	<form id="existing_game_invites" action="<?php echo make_url('ask'); ?>" method="post">

	</form>
	<div class="game_invite" id="__game_invite_template" style="display: none;">
		<div class="content">
			<div class="title">You have been invited to a new game!</div>
			<p>
				<b>Player: </b><span class="player_name">Player name</span>
			</p>
			<div class="buttons">
				<button class="button button-standard button-accept"><img src="/images/spinning_16.gif" style="display: none;">Accept</button>
				<button class="button button-silver button-reject"><img src="/images/spinning_16.gif" style="display: none;">Reject</button>
			</div>
		</div>
		<div class="bg"></div>
	</div>
</div>