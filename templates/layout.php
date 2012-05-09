<!DOCTYPE html>
<html lang="<?php echo \caspar\core\Caspar::getI18n()->getHTMLLanguage(); ?>">
	<head>
		<meta charset="<?php echo \caspar\core\Caspar::getI18n()->getCharset(); ?>">
		<?php \caspar\core\Event::createNew('core', 'header_begins')->trigger(); ?>
		<meta name="description" content="Dragon Evo - online action card game">
		<meta name="keywords" content="dragonevo dragonevotcg ccg cardgame card game action">
		<meta name="author" content="dragonevo.com">
		<link rel="shortcut icon" href="/images/favicon.ico">
		<title><?php echo strip_tags($csp_response->getTitle()); ?></title>
		<link rel="shortcut icon" href="<?php print $csp_response->getFaviconURL(); ?>">
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
		<div id="fullpage_backdrop" class="fullpage_backdrop" style="display: none;">
			<div style="position: absolute; top: 45%; left: 40%; z-index: 100001; color: #FFF; font-size: 15px; font-weight: bold;" id="fullpage_backdrop_indicator">
				<?php echo image_tag('/images/spinning_32.gif'); ?><br>
				<?php echo __('Please wait ...'); ?>
			</div>
			<div id="fullpage_backdrop_content" class="fullpage_backdrop_content"> </div>
		</div>
		<div id="dialog_backdrop" style="display: none; background-color: transparent; width: 100%; height: 100%; position: fixed; top: 0; left: 0; margin: 0; padding: 0; text-align: center; z-index: 100000;">
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
		<?php if ($csp_routing->getCurrentRouteModule() != 'game'): ?>
			<?php /*if ($csp_response->getPage() != 'home'): ?>
				<div id="header-strip">
					<div class="header-content">
						<ul>
							<?php if ($csp_user->isAuthenticated()): ?>
								<li class="<?php if ($csp_response->getPage() == 'profile') echo 'selected'; ?>"><?php echo link_tag(make_url('profile'), 'Profile'); ?></li>
								<?php if ($csp_user->isAdmin()): ?>
									<li class="<?php if (in_array($csp_response->getPage(), array('admin'))) echo 'selected'; ?>"><?php echo link_tag(make_url('admin'), 'Admin'); ?></li>
								<?php endif; ?>
								<li class="<?php if ($csp_response->getPage() == 'lobby') echo 'selected'; ?>"><?php echo link_tag(make_url('lobby'), 'Lobby'); ?></li>
								<li class="<?php if ($csp_response->getPage() == 'market') echo 'selected'; ?>"><?php echo link_tag(make_url('market'), 'Market'); ?></li>
								<li class="<?php if ($csp_response->getPage() == 'help') echo 'selected'; ?>"><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Message.success('Help is being created', 'Please be patient as we finish it');">Help</a></li>
								<li class="logout"><?php echo link_tag(make_url('logout'), 'Logout', array('class' => 'button button-silver')); ?></li>
							<?php else: ?>
								<li><a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.show('<?php echo make_url('get_backdrop_partial', array('key' => 'login')); ?>')">Login</a></li>
							<?php endif; ?>
						</ul>
						<a class="header-logo" href="<?php echo make_url('home'); ?>">
							Dragon Evo<br>
							The Card Game
						</a>
					</div>
				</div>
			<?php endif; */?>
			<div class="main-content">
				<div class="banner-container">
					<img src="/images/banner.jpg">
					<a class="devo-box" href="<?php echo make_url('home'); ?>">
						DRAGON EVO<br>
						<span class="slogan">the online action card game</span>
					</a>
					<?php /* <a class="play-now" href="#">Play now!</a> */ ?>
				</div>
				<ul class="main-menu">
					<li><a href="<?php echo make_url('home'); ?>" class="<?php if ($csp_response->getPage() == 'home') echo ' selected'; ?>">Home</a></li>
					<li><a href="<?php echo make_url('unavailable'); ?>">Media</a></li>
					<li><a href="<?php echo make_url('unavailable'); ?>">The game</a></li>
					<li><a href="<?php echo make_url('unavailable'); ?>">Marketplace</a></li>
					<li><a href="<?php echo make_url('unavailable'); ?>">Lobby</a></li>
					<li><a href="<?php echo make_url('unavailable'); ?>">FAQ</a></li>
				</ul>
				<?php echo $content; ?>
				<?php // \caspar\core\Debugger::display(); ?>
				<br style="clear: both;">
				<footer>
					<div class="border-container">
						<div class="border-overlay"></div>
					</div>
					<div class="footer-info">
						All text and artwork &copy; 2011-<?php echo date('Y'); ?> The Dragon Evo team / <a href="mailto:support@dragonevo.com">support@dragonevo.com</a>
						<?php if ($csp_user->isAdmin()): ?>
							/ <strong><?php echo link_tag(make_url('admin'), 'Admin CP'); ?></strong>
						<?php endif; ?>
					</div>
				</footer>
			</div>
		<?php else: ?>
			<?php echo $content; ?>
		<?php endif; ?>
	</body>
</html>