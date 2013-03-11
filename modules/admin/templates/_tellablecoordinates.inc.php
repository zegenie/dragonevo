<div class="backdrop_box huge" id="coordinates_popup">
	<div id="backdrop_detail_content" class="rounded_top">
		<h2>Place on map</h2>
		<div class="content">
			Drag the map to the location you want, then click the "Place on map" button and point on the map to set the coordinates. Click the "Place on map" button again to point it on a different location on the map.<br>
			You can click the adventure or story point to hide it and show the existing quest coordinates.<br>
			<br>
			Click the "Done" button or "Close" (in the bottom corner) when you're done.<br>
			<br>
			<a href="javascript:void(0);" onclick="Devo.Admin.placePointOnMap('<?php echo $tellable->getTellableType(); ?>-<?php echo (int) $tellable->getId(); ?>-map-point');" class="button button-orange">Place on map</a>
			<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();" class="button button-green">Close</a>
		</div>
		<br style="clear: both;">
		<div id="adventure-map" draggable="false">
			<div class="border stretch top"></div>
			<div class="border stretch left"></div>
			<div class="border stretch right"></div>
			<div class="border stretch bottom"></div>
			<div id="adventure-map-image">
				<?php if (!$tellable->getB2DBID()): ?>
					<?php $tellable->setName('New map point'); ?>
					<div id="<?php echo $tellable->getTellableType(); ?>-0-map-point" class="map-point <?php echo $tellable->getTellableType(); ?> selected" style="left: <?php echo $tellable->getCoordinateX(); ?>px; top: <?php echo $tellable->getCoordinateY(); ?>px; display: none;"></div>
					<?php include_template('adventure/infopopup', array('tellable' => $tellable)); ?>
				<?php endif; ?>
				<?php foreach ($stories as $story): ?>
					<div id="story-<?php echo $story->getId(); ?>-map-points-container" class="map-point-container story selected" data-tellable-type="story">
						<div id="story-<?php echo $story->getId(); ?>-map-point" class="map-point story" onclick="$(this).addClassName('selected');" style="left: <?php echo $story->getCoordinateX(); ?>px; top: <?php echo $story->getCoordinateY(); ?>px;"></div>
						<?php include_template('adventure/infopopup', array('tellable' => $story)); ?>
						<?php foreach ($story->getChapters() as $chapter): ?>
							<?php foreach ($chapter->getParts() as $part): ?>
								<div id="part-<?php echo $part->getId(); ?>-map-point" class="map-point part" style="left: <?php echo $part->getCoordinateX(); ?>px; top: <?php echo $part->getCoordinateY(); ?>px;"></div>
								<?php include_template('adventure/infopopup', array('tellable' => $part)); ?>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<?php foreach ($adventures as $adventure): ?>
					<div id="adventure-<?php echo $adventure->getId(); ?>-map-points-container" class="map-point-container adventure selected" data-tellable-type="adventure">
						<div id="adventure-<?php echo $adventure->getId(); ?>-map-point" class="map-point adventure" onclick="$(this).addClassName('selected');" style="left: <?php echo $adventure->getCoordinateX(); ?>px; top: <?php echo $adventure->getCoordinateY(); ?>px;"></div>
						<?php include_template('adventure/infopopup', array('tellable' => $adventure)); ?>
						<?php foreach ($adventure->getParts() as $part): ?>
							<div id="part-<?php echo $part->getId(); ?>-map-point" class="map-point part" style="left: <?php echo $part->getCoordinateX(); ?>px; top: <?php echo $part->getCoordinateY(); ?>px;"></div>
							<?php include_template('adventure/infopopup', array('tellable' => $part)); ?>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
				<img ondrag="return false;" src="/images/worldmap.jpg" draggable="false">
			</div>
		</div>
		<script>
			$('adventure-map').observe('mousedown', Devo.Main.startMapDrag);
			$('adventure-map').observe('mouseup', Devo.Main.stopMapDrag);
			window.setTimeout(function() {
				Devo.Main.mapFocus(<?php echo $tellable->getCoordinateX(); ?>, <?php echo $tellable->getCoordinateY(); ?>);
			}, 1000);
		</script>
		<br style="clear: both;">
	</div>
	<div class="backdrop_detail_footer">
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();">Close</a>
	</div>
</div>
