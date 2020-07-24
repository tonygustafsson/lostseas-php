<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/docks_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<?php if ($user['email'] == "" && (time() - strtotime($user['created'])) < 180): ?>
	<div class="success">
		<p>
			Welcome to <?=$this->config->item('site_name')?>! To
			get
			the full game experience, and to be able to
			go back were you left off, you have to register with your email address.
		</p>
	</div>
	<?php endif; ?>

	<p>
		<?=$game['greeting']?>
	</p>

	<?php if (isset($game['warnings'])): ?>
	<h3>Obstacles</h3>
	<ul class="ocean-event-results">
		<?php foreach ($game['warnings'] as $warnings): ?>
		<?php foreach ($warnings as $svg_id => $warning): ?>
		<li>
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#icon-<?=$svg_id?>"></use>
			</svg>
			<?=$warning?>
		</li>
		<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if (isset($game['todo'])): ?>
	<h3>Before you leave again</h3>
	<ul class="ocean-event-results">
		<?php foreach ($game['todo'] as $todo): ?>
		<?php foreach ($todo as $svg_id => $msg): ?>
		<li>
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#icon-<?=$svg_id?>"></use>
			</svg>
			<?=$msg?>
		</li>
		<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>