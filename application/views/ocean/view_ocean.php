<div class="container">
	<h2>Caribbean Sea</h2>

	<?php if (isset($game['won'])): ?>
	<p><?=$game['won']?>
	</p>
	<?php endif; ?>

	<?php if (isset($game['lost'])): ?>
	<p><?=$game['lost']?>
	</p>
	<?php endif; ?>

	<?php if (isset($game['good'])): ?>
	<ul class="ocean-event-results">
		<?php foreach ($game['good'] as $image => $msg): ?>
		<li class="positive">
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#<?=$svg_id?>"></use>
			</svg>
			<?=$msg?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if (isset($game['bad'])): ?>
	<ul>
		<?php foreach ($game['bad'] as $image => $msg): ?>
		<li class="negative">
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#<?=$svg_id?>"></use>
			</svg>
			<?=$msg?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if (! isset($game['good']) && ! isset($game['bad'])): ?>
	<p>
		<?=$game['greeting']?>
	</p>
	<?php endif; ?>

	<?php include(__DIR__. '/ocean_map.php'); ?>
</div>