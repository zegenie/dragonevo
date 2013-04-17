<div class="backdrop_box large" id="editprofile_popup">
	<div id="backdrop_detail_content">
		<h1>
			<a href="javascript:void(0);" class="ui_button" onclick="Devo.Main.Helpers.Backdrop.reset();$('fullpage_backdrop_content').update('');" style="font-size: 0.7em; font-weight: normal; float: right;">Close</a>
			<?php echo $headermode; ?> leaderboard
		</h1>
		<ul class="leaderboard" style="max-height: 700px; overflow: auto;">
			<?php foreach ($users as $user): ?>
				<li>
					<span class="rank">#<?php echo $user['rank']; ?></span><span class="points"><?php echo $user['points']; ?> points</span><?php echo $user['name']; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<br style="clear: both;">
		<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
			<a href="javascript:void(0);" class="ui_button" onclick="Devo.Main.Helpers.Backdrop.reset();$('fullpage_backdrop_content').update('');" style="font-size: 0.9em; font-weight: normal;">Close</a>
		</div>
	</div>
</div>
