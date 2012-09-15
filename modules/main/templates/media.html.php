<?php

	$csp_response->addJavascript('/js/jquery-1.7.2.min.js');
	$csp_response->addJavascript('/js/lightbox.js');
	$csp_response->addStylesheet('/css/lightbox.css');

	$csp_response->setTitle('Dragon Evo - media gallery');
	$csp_response->setPage('media');

?>
<script>
	jQuery.noConflict();
</script>
<div class="content full">
	<h1 style="margin-top: 30px;">Card art</h1>
	<h5>Rutai</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first">
				<a href="/images/media/card_art/rutai_townpeople.jpg" rel="lightbox[rutai_cards]" title="Rutai town people"><img src="/images/media/card_art/rutai_townpeople_thumb.jpg"></a>
			</div>
			<div class="single">
				<a href="/images/media/card_art/rutai_guard.jpg" rel="lightbox[rutai_cards]" title="Rutai guard"><img src="/images/media/card_art/rutai_guard_thumb.jpg"></a>
			</div>
			<div class="single last">
				<a href="/images/media/card_art/rutai_darkmage.jpg" rel="lightbox[rutai_cards]" title="Rutai dark mage"><img src="/images/media/card_art/rutai_darkmage_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h5>Hologev</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first">
				<a href="/images/media/card_art/hologev_villager.jpg" rel="lightbox[hologev_cards]" title="Hologev villager"><img src="/images/media/card_art/hologev_villager_thumb.jpg"></a>
			</div>
			<div class="single last">
				<a href="/images/media/card_art/hologev_mage.jpg" rel="lightbox[hologev_cards]" title="Hologev mage"><img src="/images/media/card_art/hologev_mage_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h5>Highwinds</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first">
				<a href="/images/media/card_art/highwinds_campdefender.jpg" rel="lightbox[highwinds_cards]" title="Highwinds camp defender"><img src="/images/media/card_art/highwinds_campdefender_thumb.jpg"></a>
			</div>
			<div class="single">
				<a href="/images/media/card_art/highwinds_druid.jpg" rel="lightbox[highwinds_cards]" title="Highwinds druid"><img src="/images/media/card_art/highwinds_druid_thumb.jpg"></a>
			</div>
			<div class="single last">
				<a href="/images/media/card_art/highwinds_deserter.jpg" rel="lightbox[highwinds_cards]" title="Highwinds deserter"><img src="/images/media/card_art/highwinds_deserter_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h1 style="margin-top: 30px;">Screenshots</h1>
	<div class="imageRow">
		<?php for ($cc = 1; $cc <= 30; $cc++): ?>
			<?php if ($cc % 5): ?><div class="set"><?php endif; ?>
				<div class="single">
					<a href="/images/media/screenshots/<?php echo $cc; ?>.png" rel="lightbox[screenshots]" title="In-game screenshot <?php echo $cc; ?>"><img src="/images/media/screenshots/<?php echo $cc; ?>.png"></a>
				</div>
			<?php if ($cc % 5): ?></div><?php endif; ?>
		<?php endfor; ?>
	</div>
	<h1 style="margin-top: 30px;">Videos</h1>
	<p class="faded_out">
		No videos yet
	</p>
</div>