<?php $csp_response->setTitle('Dragon evo admin super powers!'); ?>
<div class="content left">
	<?php include_template('admin/adminmenu'); ?>
</div>
<div class="content right">
	<div class="feature">
		<h6>Player statistics</h6>
		<p>
			<strong>Number of registered players:</strong> <?php echo $registered_users['total']; ?><br>
			<strong>Number of logged in players:</strong> <?php echo $loggedin_users['total']; ?><br>
			<br>
			<strong>Players registered last 7 days:</strong> <?php echo $registered_users['last_week']; ?><br>
			<strong>Players registered last 24 hours:</strong> <?php echo $registered_users['last_24']; ?><br>
			<br>
			<strong>Players logged in last 7 days:</strong> <?php echo $loggedin_users['last_week']; ?><br>
			<strong>Players logged in last 24 hours:</strong> <?php echo $loggedin_users['last_24']; ?>
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
			<strong>Total number of user cards:</strong> <?php echo $eventcards + $creaturecards + $itemcards; ?><br>
			<br>
			<strong>Number of user Creature cards:</strong> <?php echo $creaturecards; ?><br>
			<strong>Number of user Item cards:</strong> <?php echo $itemcards; ?><br>
			<strong>Number of user Event cards:</strong> <?php echo $eventcards; ?>
		</p>
	</div>
</div>