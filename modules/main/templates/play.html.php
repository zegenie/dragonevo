<?php 

	$csp_response->setTitle('Play Dragon Evo:TCG');
//	$faction_names = array('resistance' => 'Hologev', 'neutrals' => 'Highwinds', 'rutai' => 'Rutai');

?>
<a href="javascript:void(0);" onclick="Devo.Core.toggleFullscreen();" id="toggle-fullscreen-button" class="button button-silver button-icon" style="display: none;">Toggle fullscreen</a>
<?php include_template('main/gamemenu'); ?>
<script>
	Devo.Core.Events.listen('devo:core:initialized', function(options) {
		$('fullpage_backdrop').hide();
		if (Devo.Core.detectFullScreenSupport()) {
			$('toggle-fullscreen-button').appear();
		}
	});
</script>