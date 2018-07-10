<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Tony Gustafsson">
	
	<?php if (! isset($meta_description)): ?>
		<meta name="description" content="A pirate influenced web game! Defeat enemy ships and get a higher rank, or just travel from town to town to explore.">
	<?php else: ?>
		<meta name="description" content="<?php echo $meta_description?>">
	<?php endif; ?>
	
	<?php if (! isset($meta_keywords)): ?>
		<meta name="keywords" content="lost seas, online game, web game, pirate game, html5 game, ajax game, pirates gold">
	<?php else: ?>
		<meta name="keywords" content="<?php echo $meta_keywords?>">
	<?php endif; ?>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<base href="<?php echo base_url()?>">

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/icons/favicon.ico')?>">
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url('feed')?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/stylesheets/960gs.css?201309081542')?>" type="text/css" media="all">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url('assets/stylesheets/screen.css?201309081542')?>" type="text/css" media="all">

	<?php if (strpos(base_url(), 'test') === FALSE): ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-40457155-1', 'lostseas.com');
			ga('send', 'pageview');
		</script>
	<?php endif; ?>
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/javascript/main.js?201309081542')?>"></script>
	
	<title><?php echo $page_title?></title>
</head>

<body>

	<?php if (strpos(base_url(), 'test') !== FALSE): ?>
		<section style="position: absolute; top: 10px; left: 10px;">
			<p style="color: red; background: #fff">T E S T</p>
		</section>
	<?php endif; ?>
	
	<?php if ($this->input->is_ajax_request() === FALSE && isset($user['admin']) && $user['admin'] == 1): ?>
		<section id="initial_page_load" style="position: absolute; top: 10px; left: 10px;">
			<p style="color: red; background: #fff">Initial page load!</p>
		</section>
	<?php endif; ?>

	<?php if (isset($user['admin']) && $user['admin'] == 1): ?>
		<section style="position: absolute; top: 10px; right: 10px;">
			<a class="ajaxHTML" title="Enter God Mode!" href="<?php echo base_url('godmode/index/' . $user['id'])?>"><img src="<?php echo base_url('assets/images/icons/godmode.png')?>" alt="God mode"></a>
		</section>
	<?php endif; ?>

	<div class="container container_12">
		<header class="grid_12">
			<h1><a title="Go back to start page" href="<?php echo base_url()?>"><?php echo $this->config->item('site_name')?></a></h1>
		</header>
		
		<?php if (isset($user)): ?>
			<a id="nav_top_button" href="#">
				<img src="<?php echo base_url('assets/images/icons/game.png')?>" alt="Game menu">
			</a>
			
			<a id="action_panel_button" href="#">
				<img src="<?php echo base_url('assets/images/icons/action.png')?>" alt="Action menu">
			</a>
			
			<a id="inventory_panel_button" href="#">
				<img src="<?php echo base_url('assets/images/icons/food.png')?>" alt="Inventory menu">
			</a>
		<?php else: ?>
			<a id="inventory_panel_button" href="#">
				<img src="<?php echo base_url('assets/images/icons/login.png')?>" alt="Login menu">
			</a>
		<?php endif; ?>

		<nav id="nav_top" class="grid_12">
			<?php if (isset($user)): ?>
				<ul>
					<li><a class="ajaxHTML" id="nav_game" title="Continue playing" href="<?php echo base_url()?>">Game</a></li>
					<?php if ($user['verified'] == 0): ?>
						<li><a class="ajaxHTML" id="nav_register" title="Please register to save this game!" href="<?php echo base_url('account/register')?>">Register</a></li>
					<?php endif; ?>
					<?php if ($user['verified'] == 1): ?>
						<li><a class="ajaxHTML" id="nav_players" title="Other players" href="<?php echo base_url('inventory/players')?>">Players</a></li>
						<li><a class="newWindow" id="nav_chat" title="Chat" href="<?php echo base_url('chat')?>">Chat</a></li>
					<?php else: ?>
						<li><a class="disabled" id="nav_players" title="This option will be enabled when you are registered!" href="<?php echo base_url('inventory/players')?>">Players</a></li>
						<li><a class="disabled" id="nav_chat" title="This option will be enabled when you are registered!" href="<?php echo base_url('chat')?>">Chat</a></li>
					<?php endif; ?>
					<li><a class="ajaxHTML" id="nav_about" title="What's new in here?" href="<?php echo base_url('about')?>">About</a></li>
					<?php if ($user['verified'] == 1): ?>
						<li><a class="ajaxHTML" id="nav_settings" title="Change your settings" href="<?php echo base_url('account/settings_account')?>">Settings</a></li>
					<?php else: ?>
						<li><a class="disabled" id="nav_settings" title="This option will be enabled when you are registered!" href="<?php echo base_url('account/settings_account')?>">Settings</a></li>
					<?php endif; ?>
					<li><a id="nav_logout" title="Log out from this game" href="<?php echo base_url('account/logout')?>">Quit</a></li>
				</ul>

				<div id="music_control" style="display: inline-table; padding-left: 20px; padding-top: 15px;" data-autoplay="<?php echo ($user['music_play'] == 1) ? 'yes' : 'no';?>" data-musicvolume="<?php echo $user['music_volume']?>">
					<a href="#" id="sound_controls_icon" title="Control music and sound effects"><img src="<?php echo base_url('assets/images/icons/sound_controls.png')?>" alt="Sound controls"></a>
				</div>
				
				<div id="sound_controls" title="Sound control">
					<h3 style="margin-bottom: 0.5em;">Music</h3>
					<?php if ($user['music_play'] == 1): ?>
						<a id="music_link" title="Pause game music" href="javascript:musicControl();"><img id="music_icon" src="<?php echo base_url('assets/images/icons/music_pause.png')?>" alt="Pause"></a>
					<?php else: ?>
						<a id="music_link" title="Play game music" href="javascript:musicControl();"><img id="music_icon" src="<?php echo base_url('assets/images/icons/music_play.png')?>" alt="Play"></a>
					<?php endif; ?>
					<a title="Next song, please" style="padding-left: 0.5em;" href="javascript:changeSong();"><img src="<?php echo base_url('assets/images/icons/music_next.png')?>" alt="Change track"></a>
					
					<p>Volume:</p>
					<div id="music_volume_slider"></div>
					
					<h3 style="margin: 0.5em 0;">Sound effects</h3>
					<p id="sound_effects">
						On <input type="radio" name="sound_effects" value="1"<?php echo ($user['sound_effects_play'] == 1) ? ' checked' : ''?>>
						Off <input type="radio" name="sound_effects" value="0"<?php echo ($user['sound_effects_play'] == 0) ? ' checked' : ''?>>
					</p>
				</div>

			<?php else: ?>
				<p style="padding-left: 2em;"><em>A pirate influenced web game.</em></p>
			<?php endif; ?>
		</nav>
	
		<?php if (isset($user)): ?>
			<?php /* For logged in users! */ ?>	
			<aside id="action_panel" class="grid_2">
				<h3>Action</h3>

				<?php $in_town = array('dock', 'shop', 'tavern', 'shipyard', 'cityhall', 'market', 'bank'); ?>
				<nav id="nav_dock" style="<?php echo (in_array($game['place'], $in_town)) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Visit the shop" href="<?php echo base_url('shop')?>"><img src="<?php echo base_url('assets/images/icons/shop.png')?>" alt="Shop" width="32" height="32">Shop</a></div>
					<div><a class="ajaxHTML" title="Visit the tavern" href="<?php echo base_url('tavern')?>"><img src="<?php echo base_url('assets/images/icons/tavern.png')?>" alt="Tavern" width="32" height="32">Tavern</a></div>
					<div><a class="ajaxHTML" title="Visit the city hall" href="<?php echo base_url('cityhall')?>"><img src="<?php echo base_url('assets/images/icons/cityhall.png')?>" alt="City Hall" width="32" height="32">City Hall</a></div>
					<div><a class="ajaxHTML" title="Visit the bank" href="<?php echo base_url('bank')?>"><img src="<?php echo base_url('assets/images/icons/bank.png')?>" alt="Bank" width="32" height="32">Bank</a></div>
					<div><a class="ajaxHTML" title="Visit the shipyard" href="<?php echo base_url('shipyard')?>"><img src="<?php echo base_url('assets/images/icons/shipyard.png')?>" alt="Shipyard" width="32" height="32">Shipyard</a></div>
					<div><a class="ajaxHTML" title="Visit the market" href="<?php echo base_url('market')?>"><img src="<?php echo base_url('assets/images/icons/market.png')?>" alt="Market" width="32" height="32">Market</a></div>
					<div><a class="ajaxHTML" title="Go out to sea!" href="<?php echo base_url('harbor')?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Harbor" width="32" height="32">Harbor</a></div>
				</nav>

				<nav id="nav_harbor" style="<?php echo ($game['place'] == 'harbor' && empty($game['event_ship'])) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Explore the ocean" href="<?php echo base_url('ocean')?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Explore" width="32" height="32">Explore</a></div>
					<div><a class="ajaxHTML" title="Land at this town" href="<?php echo base_url('dock')?>"><img src="<?php echo base_url('assets/images/icons/dock.png')?>" alt="Land" width="32" height="32">Land</a></div>
				</nav>

				<nav id="nav_ocean" style="<?php echo ($game['place'] == 'ocean' && (empty($game['event_ship']) && empty($game['event_ship_won']) && empty($game['event_ocean_trade']))) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Explore the ocean" href="<?php echo base_url('ocean')?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Explore" width="32" height="32">Explore</a></div>
				</nav>
				
				<?php if (! empty($this->user['game']['event_ship'])) { list($nation, $type, $crew, $cannons) = explode('###', $this->user['game']['event_ship']); } else { $nation = NULL; } ?>
			
				<nav id="nav_ship_meeting_unfriendly" style="<?php echo (! empty($game['event_ship']) && ($nation == 'pirate' || $nation == $game['enemy'])) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Attack this ship!" href="<?php echo base_url('ocean/attack')?>"><img src="<?php echo base_url('assets/images/icons/attack.png')?>" alt="Attack" width="32" height="32">Attack</a></div>
					<div><a class="ajaxHTML" title="Try to flee!" href="<?php echo base_url('ocean/flee')?>"><img src="<?php echo base_url('assets/images/icons/flee.png')?>" alt="Flee" width="32" height="32">Flee</a></div>
				</nav>
				
				<nav id="nav_ship_meeting_friendly" style="<?php echo (! empty($game['event_ship']) && ($nation == $game['nationality'])) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Attack this ship!" href="<?php echo base_url('ocean/attack')?>"><img src="<?php echo base_url('assets/images/icons/attack.png')?>" alt="Attack" width="32" height="32">Attack</a></div>
					<div><a class="ajaxHTML" title="Trade with these sea men" href="<?php echo base_url('ocean/trade')?>"><img src="<?php echo base_url('assets/images/icons/trade.png')?>" alt="Trade" width="32" height="32">Trade</a></div>
					<div><a class="ajaxHTML" title="Ignore this ship" href="<?php echo base_url('ocean/ignore')?>"><img src="<?php echo base_url('assets/images/icons/flee.png')?>" alt="Ignore" width="32" height="32">Ignore</a></div>
				</nav>
				
				<nav id="nav_ship_meeting_neutral" style="<?php echo (! empty($game['event_ship']) && ($nation != $game['nationality']) && $nation != 'pirate' && $nation != $game['nationality'] && $nation !== NULL) ? 'display: block; ' : 'display: none; '?>">
					<div><a class="ajaxHTML" title="Attack this ship!" href="<?php echo base_url('ocean/attack')?>"><img src="<?php echo base_url('assets/images/icons/attack.png')?>" alt="Attack" width="32" height="32">Attack</a></div>
					<div><a class="ajaxHTML" title="Ignore this ship" href="<?php echo base_url('ocean/ignore')?>"><img src="<?php echo base_url('assets/images/icons/flee.png')?>" alt="Ignore" width="32" height="32">Ignore</a></div>
				</nav>

			</aside>
		<?php endif; ?>

		<article id="main" class="grid_8">