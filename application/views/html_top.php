<!DOCTYPE html>
<html lang="en">

<head>
	<?php if (strpos(base_url(), 'localhost') === false): ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async
		src="https://www.googletagmanager.com/gtag/js?id=<?=$this->config->item('google_analytics_id')?>">
	</script>
	<script>
		window.dataLayer = window.dataLayer || [];
		window.googleAnalyticsId =
			'<?=$this->config->item('google_analytics_id')?>';

		function gtag() {
			dataLayer.push(arguments);
		}

		gtag('js', new Date());
		gtag('config',
			'<?=$this->config->item('google_analytics_id')?>');
	</script>
	<?php endif; ?>

	<script>
		if ('serviceWorker' in navigator) {
			navigator.serviceWorker
				.register(
					'<?=base_url('/serviceWorker.js')?>',
				);
		};

		window.appPath = '<?=base_url()?>';
	</script>

	<meta charset="utf-8">
	<meta name="author" content="Tony Gustafsson">

	<?php if (! isset($meta_description)): ?>
	<meta name="description"
		content="A pirate influenced web game! Defeat enemy ships and get a higher rank, or just travel from town to town to explore.">
	<?php else: ?>
	<meta name="description" content="<?=$meta_description?>">
	<?php endif; ?>

	<?php if (! isset($meta_keywords)): ?>
	<meta name="keywords" content="lost seas, online game, web game, pirate game, html5 game, ajax game, pirates gold">
	<?php else: ?>
	<meta name="keywords" content="<?=$meta_keywords?>">
	<?php endif; ?>

	<meta name="theme-color" content="#e5f0f6" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="manifest"
		href="<?=base_url('site.webmanifest')?>">

	<link rel="apple-touch-icon"
		href="<?=base_url('assets/images/logo.png')?>">
	<link rel="icon" type="image/svg+xml"
		href="<?=base_url('assets/images/favicon.svg')?>">
	<link href="https://fonts.googleapis.com/css2?family=Montaga" rel="stylesheet">

	<title>
		<?=$page_title?>
	</title>

	<script>
		<?php require(__DIR__ . '/../../assets/js/styles.js'); ?>
	</script>
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
		<?php if ($this->input->is_ajax_request() === false && isset($user['admin']) && $user['admin'] == 1): ?>
		<script>
			window.isAdmin = true;
		</script>
		<?php endif; ?>

		<?php
            include('partials/header_panel.php');
        ?>

		<?php if (isset($user)): ?>
		<?php include('partials/action_panel.php') ?>
		<?php endif; ?>

		<article id="main" class="content-panel">