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
					'<?=base_url('assets/js/serviceWorker.js')?>'
				);
		};
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

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<base href="<?=base_url()?>">

	<link rel="manifest"
		href="<?=base_url('site.webmanifest')?>">

	<link rel="icon" type="image/svg+xml"
		href="<?=base_url('assets/images/favicon.svg')?>">
	<link href="https://fonts.googleapis.com/css2?family=Montaga&display=swap" rel="stylesheet">

	<title>
		<?=$page_title?>
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

		<?php
            include('partials/header_panel.php');
        ?>

		<?php if (isset($user)): ?>
		<?php include('partials/action_panel.php') ?>
		<?php endif; ?>

		<article id="main" class="content-panel">