<!DOCTYPE html>
<html lang="<?php echo \caspar\core\Caspar::getI18n()->getHTMLLanguage(); ?>">
	<head>
		<meta charset="<?php echo \caspar\core\Caspar::getI18n()->getCharset(); ?>">
		<?php \caspar\core\Event::createNew('core', 'header_begins')->trigger(); ?>
		<meta name="description" content="Dragon Evo - online action card game">
		<meta name="keywords" content="dragonevo dragonevotcg ccg cardgame card game action">
		<meta name="author" content="dragonevo.com">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="/images/favicon.png">
		<title><?php echo strip_tags($csp_response->getTitle()); ?></title>
		<?php foreach ($csp_response->getFeeds() as $feed_url => $feed_title): ?>
			<link rel="alternate" type="application/rss+xml" title="<?php echo str_replace('"', '\'', $feed_title); ?>" href="<?php echo $feed_url; ?>">
		<?php endforeach; ?>
		<?php foreach ($csp_response->getStylesheets() as $css): ?>
			<link rel="stylesheet" href="<?php echo $css; ?>">
		<?php endforeach; ?>

		<?php foreach ($csp_response->getJavascripts() as $js): ?>
			<script type="text/javascript" src="<?php echo $js; ?>"></script>
		<?php endforeach; ?>
		  <!--[if lt IE 9]>
			  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		  <![endif]-->
		<?php \caspar\core\Event::createNew('core', 'header_ends')->trigger(); ?>
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
		<div id="fullpage_backdrop" class="fullpage_backdrop dark" style="<?php if (!$csp_response->isFullscreen()): ?>display: none;<?php endif; ?>">
			<div id="loading">
				<div class="msg">
					Loading ...
				</div>
				<img src="/images/spinning_32.gif">
			</div>
			<div id="fullpage_backdrop_content" class="fullpage_backdrop_content"> </div>
		</div>
		<div id="dialog_backdrop" style="display: none; background-color: transparent; width: 100%; height: 100%; position: fixed; top: 0; left: 0; margin: 0; padding: 0; text-align: center;">
			<div id="dialog_backdrop_content" class="fullpage_backdrop_content">
				<div class="rounded_box shadowed_box white cut_top cut_bottom bigger">
					<div style="width: 900px; text-align: left; margin: 0 auto; font-size: 13px;">
						<?php echo image_tag('/images/dialog_question.png', array('style' => 'float: left;')); ?>
						<h3 id="dialog_title"></h3>
						<p id="dialog_content"></p>
					</div>
					<div style="text-align: center; padding: 10px;">
						<?php echo image_tag('/images/spinning_20.gif', array('style' => 'float: right; display: none;', 'id' => 'dialog_indicator')); ?>
						<a href="javascript:void(0)" id="dialog_yes" class="button button-green"><?php echo __('Yes'); ?></a>
						<a href="javascript:void(0)" id="dialog_no" class="button button-red"><?php echo __('No'); ?></a>
					</div>
				</div>
			</div>
			<div style="background-color: #000; width: 100%; height: 100%; position: absolute; top: 0; left: 0; margin: 0; padding: 0; z-index: 999;" class="semi_transparent"> </div>
		</div>
		<?php if (!$csp_response->isFullscreen()): ?>
			<div class="main-content">
				<div class="banner-container">
					<?php if ($csp_routing->getCurrentRouteName() == 'home'): ?>
						<img src="/images/banner.jpg">
					<?php else: ?>
						<img src="/images/banner_shorter.jpg">
					<?php endif; ?>
					<a class="devo-box" href="<?php echo make_url('home'); ?>">
						DRAGON EVO<br>
						<span class="slogan">the online action card game</span>
					</a>
					<a class="button button-standard play-now" style="font-family: 'Gentium Basic'; border-radius: 10px; font-size: 2em; font-weight: normal; padding: 20px 10px !important;" href="<?php echo ($csp_user->isAuthenticated()) ? make_url('play') : make_url('login'); ?>">Play now!</a>
				</div>
				<ul class="main-menu">
					<li><a href="<?php echo make_url('home'); ?>" class="<?php if ($csp_response->getPage() == 'home') echo ' selected'; ?>">Home</a></li>
					<li><a href="<?php echo make_url('media'); ?>" class="<?php if ($csp_response->getPage() == 'media') echo ' selected'; ?>">Media</a></li>
					<?php if ($csp_user->isAuthenticated()): ?>
						<li><a href="<?php echo make_url('lobby'); ?>" class="<?php if ($csp_response->getPage() == 'lobby') echo ' selected'; ?>">Lobby</a></li>
						<li><a href="<?php echo make_url('profile'); ?>" class="<?php if ($csp_response->getPage() == 'profile') echo ' selected'; ?>">Profile</a></li>
					<?php endif; ?>
					<li><a href="<?php echo make_url('faq'); ?>" class="<?php if ($csp_response->getPage() == 'faq') echo ' selected'; ?>">FAQ</a></li>
				</ul>
				<?php echo $content; ?>
				<?php \caspar\core\Debugger::display(); ?>
				<br style="clear: both;">
				<footer>
					<div class="border-container">
						<div class="border-overlay"></div>
					</div>
					<div class="footer-info">
						<a href="<?php echo make_url('changelog'); ?>">Version alpha-<?php echo $csp_response->getVersion(); ?></a> - All text and artwork &copy; 2011-<?php echo date('Y'); ?> <a href="mailto:support@dragonevo.com">Magical Pictures / zegenie studios</a>
						<?php if ($csp_user->isAuthenticated()): ?>
							<br>
							<?php if ($csp_user->isAdmin()): ?>
								<strong><?php echo link_tag(make_url('admin'), 'Admin CP'); ?></strong> / 
							<?php endif; ?>
							<?php echo link_tag(make_url('logout'), 'Log out'); ?>
						<?php endif; ?>
					</div>
				</footer>
			</div>
		<?php else: ?>
			<div id="fullscreen-container">
				<?php echo $content; ?>
			</div>
		<?php endif; ?>
		<?php if ($csp_user->isAuthenticated()): ?>
			<script type="text/javascript">
//				console.log(document.getElementsByTagName('body')[0]);
				document.observe('dom:loaded', function() {
					Devo.Core.initialize({location: '<?php echo $csp_routing->getCurrentRouteName(); ?>', title: '<?php echo $csp_response->getTitle(); ?>', ask_url: '<?php echo make_url('ask'); ?>', say_url: '<?php echo make_url('say'); ?>', user_id: <?php echo $csp_user->getId(); ?>});
				});
			</script>
		<?php endif; ?>
	</body>
</html>