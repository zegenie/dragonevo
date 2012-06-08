<?php $csp_response->setTitle('Dragon evo admin super powers!'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right">
	<div class="feature">
		<h6>Player statistics</h6>
		<p>
			<strong>Number of registered players:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfRegisteredUsers(); ?><br>
			<strong>Number of logged in players:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfLoggedInUsers(); ?><br>
			<br>
			<span class="faded_out">
				<strong>Players registered last 7 days:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfRegisteredUsersLastWeek(); ?><br>
				<strong>Players registered last 24 hours:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfRegisteredUsersLast24Hours(); ?><br>
				<br>
			</span>
			<strong>Players logged in last 7 days:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfLoggedInUsersLastWeek(); ?><br>
			<strong>Players logged in last 24 hours:</strong> <?php echo application\entities\tables\Users::getTable()->getNumberOfLoggedInUsersLast24Hours(); ?>
		</p>
	</div>
	<div class="feature">
		<h5>Market statistics</h5>
		<p class="faded_out">
			<strong>Cards for sale right now:</strong> 0<br>
			<strong>Cards for trade right now:</strong> 0<br>
			<br>
			<strong>Cards sold last 24 hours:</strong> 0<br>
			<strong>Cards sold last 7 days:</strong> 0<br>
			<br>
			<strong>Market fee earned last 24 hours:</strong> 0 gold<br>
			<strong>Market fee earned last 7 days:</strong> 0 gold<br>
		</p>
	</div>
	<br style="clear: both;">
	<div class="feature">
		<h5>Game statistics</h5>
		<p>
			<strong>Ongoing games:</strong> <?php echo application\entities\tables\Games::getTable()->getNumberOfCurrentGames(); ?><br>
			<strong>Games played last 24 hours:</strong> <?php echo application\entities\tables\Games::getTable()->getNumberOfGamesLast24Hours(); ?><br>
			<strong>Games played last 7 days:</strong> <?php echo application\entities\tables\Games::getTable()->getNumberOfGamesLastWeek(); ?>
		</p>
	</div>
	<div class="feature">
		<h5>Card statistics</h5>
		<p>
			<strong>Total number of cards:</strong> <?php echo $eventcards + $creaturecards + $itemcards; ?><br>
			<br>
			<strong>Number of Creature cards:</strong> <?php echo $creaturecards; ?><br>
			<strong>Number of Item cards:</strong> <?php echo $itemcards; ?><br>
			<strong>Number of Event cards:</strong> <?php echo $eventcards; ?>
		</p>
	</div>
</div>