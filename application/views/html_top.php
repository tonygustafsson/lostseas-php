<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Tony Gustafsson">

	<?php if (! isset($meta_description)): ?>
	<meta name="description"
		content="A pirate influenced web game! Defeat enemy ships and get a higher rank, or just travel from town to town to explore.">
	<?php else: ?>
	<meta name="description"
		content="<?php echo $meta_description?>">
	<?php endif; ?>

	<?php if (! isset($meta_keywords)): ?>
	<meta name="keywords" content="lost seas, online game, web game, pirate game, html5 game, ajax game, pirates gold">
	<?php else: ?>
	<meta name="keywords" content="<?php echo $meta_keywords?>">
	<?php endif; ?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<base href="<?php echo base_url()?>">

	<link rel="shortcut icon" type="image/x-icon"
		href="<?php echo base_url('assets/images/icons/favicon.ico')?>">
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0"
		href="<?php echo base_url('feed')?>">

	<?php if (strpos(base_url(), 'test') === false): ?>
	<script>
		(function(i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function() {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-40457155-1', 'lostseas.com');
		ga('send', 'pageview');
	</script>
	<?php endif; ?>

	<title><?php echo $page_title?>
	</title>
</head>

<body id="body">
	<?php if (!isset($_SESSION['user_session_id'])): ?>
	<div class="error">
		<p>Cookies needs to be enabled to play this game!</p>
	</div>
	<?php endif; ?>

	<noscript>
		<div class="error">
			<p>This game needs JavaScript to be activated in your web browser. You can turn it on at the browser
				preferences.</p>
		</div>
	</noscript>

	<div class="grid-container">
		<?php if (strpos(base_url(), 'test') !== false): ?>
		<section style="position: absolute; top: 10px; left: 10px;">
			<p style="color: red; background: #fff">T E S T</p>
		</section>
		<?php endif; ?>

		<?php if ($this->input->is_ajax_request() === false && isset($user['admin']) && $user['admin'] == 1): ?>
		<section class="init-page-load">
			<p>Initial page load</p>
		</section>
		<?php endif; ?>

		<?php if (isset($user['admin']) && $user['admin'] == 1): ?>
		<section style="position: absolute; top: 10px; right: 10px;">
			<a class="ajaxHTML" title="Enter God Mode!"
				href="<?php echo base_url('godmode/index/' . $user['id'])?>"><img
					src="<?php echo base_url('assets/images/icons/godmode.png')?>"
					alt="God mode"></a>
		</section>
		<?php endif; ?>

		<div class="header-panel">
			<header>
				<h1><a title="Go back to start page"
						href="<?php echo base_url()?>"><?php echo $this->config->item('site_name')?></a>
				</h1>
			</header>

			<?php if (isset($user)): ?>
			<a id="nav_top_button" href="#">
				<img src="<?php echo base_url('assets/images/icons/game.png')?>"
					alt="Game menu">
			</a>

			<a id="action_panel_button" class="action-panel-button" href="#">
				<img src="<?php echo base_url('assets/images/icons/action.png')?>"
					alt="Action menu">
			</a>

			<a id="inventory_panel_button" class="inventory-panel-button" href="#">
				<img src="<?php echo base_url('assets/images/icons/food.png')?>"
					alt="Inventory menu">
			</a>
			<?php else: ?>
			<a id="inventory_panel_button" class="inventory-panel-button" href="#">
				<img src="<?php echo base_url('assets/images/icons/login.png')?>"
					alt="Login menu">
			</a>
			<?php endif; ?>

			<nav id="nav_top">
				<?php if (isset($user)): ?>
				<ul>
					<li><a id="nav_game" title="Continue playing"
							href="<?php echo base_url()?>">Game</a>
					</li>
					<?php if ($user['verified'] == 0): ?>
					<li><a class="ajaxHTML" id="nav_register" title="Please register to save this game!"
							href="<?php echo base_url('account/register')?>">Register</a>
					</li>
					<?php endif; ?>
					<?php if ($user['verified'] == 1): ?>
					<li><a class="ajaxHTML" id="nav_players" title="Other players"
							href="<?php echo base_url('inventory/players')?>">Players</a>
					</li>
					<li><a class="ajaxHTML" id="nav_chat" title="Chat"
							href="<?php echo base_url('chat')?>">Chat</a>
					</li>
					<?php else: ?>
					<li><a class="disabled" id="nav_players"
							title="This option will be enabled when you are registered!"
							href="<?php echo base_url('inventory/players')?>">Players</a>
					</li>
					<li><a class="disabled" id="nav_chat" title="This option will be enabled when you are registered!"
							href="<?php echo base_url('chat')?>">Chat</a>
					</li>
					<?php endif; ?>
					<li><a class="ajaxHTML" id="nav_about" title="What's new in here?"
							href="<?php echo base_url('about')?>">About</a>
					</li>
					<?php if ($user['verified'] == 1): ?>
					<li><a class="ajaxHTML" id="nav_settings" title="Change your settings"
							href="<?php echo base_url('account/settings_account')?>">Settings</a>
					</li>
					<?php else: ?>
					<li><a class="disabled" id="nav_settings"
							title="This option will be enabled when you are registered!"
							href="<?php echo base_url('account/settings_account')?>">Settings</a>
					</li>
					<?php endif; ?>
					<li><a id="nav_logout" title="Log out from this game"
							href="<?php echo base_url('account/logout')?>">Quit</a>
					</li>
				</ul>

				<div id="music_control" style="display: inline-table; padding-left: 20px; padding-top: 15px;"
					data-autoplay="<?php echo ($user['music_play'] == 1) ? 'yes' : 'no';?>"
					data-musicvolume="<?php echo $user['music_volume']?>">
					<a href="#" id="sound_controls_icon" title="Control music and sound effects"><img
							src="<?php echo base_url('assets/images/icons/sound_controls.png')?>"
							alt="Sound controls"></a>
				</div>
				<?php else: ?>
				<p style="padding-left: 2em;"><em>A pirate influenced web game.</em></p>
				<?php endif; ?>
			</nav>
		</div>

		<?php if (isset($user)): ?>
		<?php include('partials/actionbar.php') ?>
		<?php endif; ?>

		<article id="main" class="content-panel">