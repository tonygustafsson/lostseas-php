<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/harbor_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<div id="msg"></div>

<? if (isset($game['good'])): ?>
	<ul>
	<? foreach ($game['good'] as $image => $msg): ?>
		<li class="attack_good" style="list-style-image: url('<?echo base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>

<? if (isset($game['bad'])): ?>
	<ul>
	<? foreach ($game['bad'] as $image => $msg): ?>
		<li class="attack_bad" style="list-style-image: url('<?echo base_url('assets/images/icons/' . $image . '.png')?>');"><?=$msg?></li>
	<? endforeach; ?>
	</ul>
<? endif; ?>

<? if (! isset($game['good']) && ! isset($game['bad'])): ?>
	<p><?=$game['greeting']?></p>
<? endif; ?>