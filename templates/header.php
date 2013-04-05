<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Dragon Evo - online action card game">
		<meta name="keywords" content="dragonevo dragonevotcg ccg cardgame card game action">
		<meta name="author" content="dragonevo.com">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="/images/favicon.png">
		<title><?php echo strip_tags($tbg_response->getTitle()); ?></title>
		<link rel="stylesheet" href="http://dragonevo.com/css/styles.css">
		<script type="text/javascript" src="http://dragonevo.com/js/main.js"></script>
		<script type="text/javascript" src="http://dragonevo.com/js/prototype.js"></script>
		<script type="text/javascript" src="http://dragonevo.com/js/scriptaculous.js"></script>
		<script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="/js/jquery.markitup.js"></script>
		<script type="text/javascript" src="/js/thebuggenie.js"></script>
	</head>
	<body>
		<div class="almost_not_transparent shadowed popup_message failure" onclick="Devo.Main.Helpers.Message.clear();" style="display: none;" id="dragonevo_failuremessage">
			<div style="padding: 10px 0 10px 5px;">
				<div class="dismiss_me"><?php echo __('Click this message to dismiss it'); ?></div>
				<span style="font-weight: bold;" id="dragonevo_failuremessage_title"></span><br>
				<span id="dragonevo_failuremessage_content"></span>
			</div>
		</div>
		<div class="almost_not_transparent shadowed popup_message success" onclick="Devo.Main.Helpers.Message.clear();" style="display: none;" id="dragonevo_successmessage">
			<div style="padding: 10px 0 10px 5px;">
				<div class="dismiss_me"><?php echo __('Click this message to dismiss it'); ?></div>
				<span style="font-weight: bold;" id="dragonevo_successmessage_title"></span><br>
				<span id="dragonevo_successmessage_content"></span>
			</div>
		</div>
		<div id="dialog_backdrop" style="display: none;">
			<div id="dialog_backdrop_content" class="fullpage_backdrop_content">
				<div class="swirl-dialog">
					<img src="/images/swirl_top_right.png" class="swirl top-right">
					<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
					<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
					<img src="/images/swirl_top_left.png" class="swirl top-left">
					<h3 id="dialog_title"></h3>
					<p id="dialog_content"></p>
					<div style="text-align: center; padding: 10px;">
						<?php echo image_tag('/images/spinning_20.gif', array('style' => 'float: right; display: none;', 'id' => 'dialog_indicator')); ?>
						<a href="javascript:void(0)" id="dialog_yes" class="button button-green"><?php echo __('Yes'); ?></a>
						<a href="javascript:void(0)" id="dialog_no" class="button button-red"><?php echo __('No'); ?></a>
					</div>
				</div>
			</div>
			<div style="background-color: #000; width: 100%; height: 100%; position: absolute; top: 0; left: 0; margin: 0; padding: 0; z-index: 999;" class="semi_transparent"> </div>
		</div>
		<div class="main-content">
			<div class="banner-container">
				<img src="http://dragonevo.com/images/banner_shorter.jpg">
				<a class="devo-box" href="http://dragonevo.com">
					DRAGON EVO<br>
					<span class="slogan">the online action card game</span>
				</a>
				<a class="button button-standard play-now" style="font-family: 'Gentium Basic'; border-radius: 10px; font-size: 2em; font-weight: normal; padding: 20px 10px !important;" href="http://dragonevo.com/play">Play now!</a>
			</div>
			<ul class="main-menu">
				<li><a href="http://dragonevo.com" class="<?php if ($tbg_response->getPage() == 'home') echo ' selected'; ?>">Home</a></li>
				<li><a href="http://dragonevo.com/media" class="<?php if ($tbg_response->getPage() == 'media') echo ' selected'; ?>">Media</a></li>
					<li><a href="http://guide.dragonevo.com/wiki/GameGuide" class="selected">Game guide</a></li>
					<li><a href="http://forum.dragonevo.com">Forum</a></li>
					<li><a href="http://dragonevotcg.wordpress.com">Blog</a></li>
				<?php /* if ($csp_user->isAuthenticated()): ?>
					<li><a href="<?php echo make_url('profile'); ?>" class="<?php if ($tbg_response->getPage() == 'profile') echo ' selected'; ?>">Profile</a></li>
				<?php endif; */ ?>
				<li><a href="http://dragonevo.com/faq" class="<?php if ($tbg_response->getPage() == 'faq') echo ' selected'; ?>">FAQ</a></li>
			</ul>
