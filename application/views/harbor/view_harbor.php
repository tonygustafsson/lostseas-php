<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/harbor_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<?php if (isset($game['good'])): ?>
	<ul>
	<?php foreach ($game['good'] as $image => $msg): ?>
		<li class="attack_good" style="list-style-image: url('<?=base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (isset($game['bad'])): ?>
	<ul>
	<?php foreach ($game['bad'] as $image => $msg): ?>
		<li class="attack_bad" style="list-style-image: url('<?=base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (! isset($game['good']) && ! isset($game['bad'])): ?>
	<p><?=$game['greeting']?></p>
<?php endif; ?>