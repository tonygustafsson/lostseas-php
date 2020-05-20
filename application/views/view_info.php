<?php if (isset($header)): ?>
	<h2><?php echo $header?></h2>
<?php endif; ?>

<p><?php echo $message?></p>

<?php if (isset($reload)): ?>
	<p>You will be automatically redirected within <?php echo $reload?> seconds...</p>
	<script>setTimeout("window.location = '<?php echo base_url()?>'",<?php echo floor($reload * 1000)?>);</script>
<?php endif; ?>