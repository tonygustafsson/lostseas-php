<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/docks_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<? if ($user['email'] == "" && (time() - strtotime($user['created'])) < 180): ?>
	<div class="success">
		<p>
			Welcome to <?=$this->config->item('site_name')?>! To get the full game experience, and to be able to
			go back were you left off, you have to register with your email address.
		</p>
	</div>
<? endif; ?>

<div id="msg"></div>

<p>
	<?=$game['greeting']?>
</p>

<? if (isset($game['harbor_errors'])): ?>
	<h3>Obstacles</h3>
	<ul>
		<? foreach ($game['harbor_errors'] as $errors): ?>
			<? foreach ($errors as $image => $error): ?>
				<li style="list-style-image: url('<?echo base_url('assets/images/icons/' . $image . '.png')?>');"><?=$error?></li>
			<? endforeach; ?>
		<? endforeach; ?>
	</ul>
<? endif; ?>

<? if (isset($game['todo'])): ?>
	<h3>Before you leave again</h3>
	<ul>
		<? foreach ($game['todo'] as $todo): ?>
			<? foreach ($todo as $image => $msg): ?>
				<li style="list-style-image: url('<?echo base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
			<? endforeach; ?>
		<? endforeach; ?>
	</ul>
<? endif; ?>