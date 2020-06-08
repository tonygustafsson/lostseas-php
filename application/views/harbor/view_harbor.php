<header
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/harbor_' . $game['nation'] . '.jpg')?>"
		class="header">
</header>

<?php if (isset($game['good'])): ?>
<ul class="ocean-event-results">
	<?php foreach ($game['good'] as $svg_id => $msg): ?>
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
	<?php foreach ($game['bad'] as $svg_id => $msg): ?>
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
<p><?=$game['greeting']?>
</p>
<?php endif;
