<? if (isset($header)): ?>
	<h2><?=$header?></h2>
<? endif; ?>

<p><?=$message?></p>

<? if (isset($reload)): ?>
	<p>You will be automatically redirected within <?=$reload?> seconds...</p>
	<script>setTimeout("window.location = '<?echo base_url()?>'",<?echo floor($reload * 1000)?>);</script>
<? endif; ?>