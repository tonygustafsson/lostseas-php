<? if (isset($header)): ?>
	<h2><?php echo $header?></h2>
<? endif; ?>

<p><?php echo $message?></p>

<? if (isset($reload)): ?>
	<p>You will be automatically redirected within <?php echo $reload?> seconds...</p>
	<script>setTimeout("window.location = '<?echo base_url()?>'",<?echo floor($reload * 1000)?>);</script>
<? endif; ?>