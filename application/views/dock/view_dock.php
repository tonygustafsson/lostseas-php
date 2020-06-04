<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/docks_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<?php if ($user['email'] == "" && (time() - strtotime($user['created'])) < 180): ?>
	<div class="success">
		<p>
			Welcome to <?=$this->config->item('site_name')?>! To get the full game experience, and to be able to
			go back were you left off, you have to register with your email address.
		</p>
	</div>
<?php endif; ?>

<p>
	<?=$game['greeting']?>
</p>

<?php if (isset($game['harbor_errors'])): ?>
	<h3>Obstacles</h3>
	<ul>
		<?php foreach ($game['harbor_errors'] as $errors): ?>
			<?php foreach ($errors as $image => $error): ?>
				<li style="list-style-image: url('<?=base_url('assets/images/icons/' . $image . '.png')?>');"><?=$error?></li>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (isset($game['todo'])): ?>
	<h3>Before you leave again</h3>
	<ul>
		<?php foreach ($game['todo'] as $todo): ?>
			<?php foreach ($todo as $image => $msg): ?>
				<li style="list-style-image: url('<?=base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>