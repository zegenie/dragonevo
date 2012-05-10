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
	<h1>Screenshots</h1>
	<p class="faded_out">
		No screenshots yet
	</p>
	<h1 style="margin-top: 30px;">Concept art</h1>
	<div class="imageRow">
		<div class="set">
			<div class="single first">
				<a href="/images/media/card_art/concept_druid.jpg" rel="lightbox[concept_art]" title="Druid concept drawing"><img src="/images/media/card_art/concept_druid_thumb.jpg"></a>
			</div>
			<div class="single last">
				<a href="/images/media/card_art/concept_guard.jpg" rel="lightbox[concept_art]" title="Rutai guard concept drawing"><img src="/images/media/card_art/concept_guard_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h1 style="margin-top: 30px;">Card art</h1>
	<h5>Rutai</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first last">
				<a href="/images/media/card_art/rutai_townpeople.jpg" rel="lightbox[rutai_cards]" title="Rutai town people"><img src="/images/media/card_art/rutai_townpeople_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h5>Hologev</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first last">
				<a href="/images/media/card_art/hologev_villager.jpg" rel="lightbox[hologev_cards]" title="Hologev villager"><img src="/images/media/card_art/hologev_villager_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h5>Highwinds</h5>
	<div class="imageRow">
		<div class="set">
			<div class="single first last">
				<a href="/images/media/card_art/highwinds_campdefender.jpg" rel="lightbox[highwinds_cards]" title="Highwinds camp defender"><img src="/images/media/card_art/highwinds_campdefender_thumb.jpg"></a>
			</div>
		</div>
	</div>
	<h1 style="margin-top: 30px;">Videos</h1>
	<p class="faded_out">
		No videos yet
	</p>
</div>