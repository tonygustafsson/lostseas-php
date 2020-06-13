<?php if (isset($header)): ?>
<h2 class="area-header__heading"><?=$header?>
</h2>
<?php endif; ?>

<div class="container">
	<p><?=$message?>
	</p>

	<?php if (isset($reload)): ?>
	<p>You will be automatically redirected within <?=$reload?>
		seconds...</p>
	<script>
		setTimeout(
			"window.location = '<?=base_url()?>'", <?=floor($reload * 1000)?>
			);
	</script>
	<?php endif; ?>
</div>