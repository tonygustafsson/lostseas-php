<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/tavern_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<p>
	<?php echo $game['greeting']?>
</p>

<section class="actions">
	<a class="ajaxHTML" title="Buy something to eat or drink" href="tavern"><img src="<?php echo base_url('assets/images/icons/tavern_buy.png')?>" alt="Buy" width="32" height="32">Buy</a>
	<?php if ($game['event_sailors'] != 'banned'): ?>
		<a id="actions_sailors" class="ajaxHTML" title="Talk to the sailors at the bar" href="<?php echo base_url('tavern/sailors')?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Sailors" width="32" height="32">Sailors</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Gamble for gold!" href="tavern/gamble"><img src="<?php echo base_url('assets/images/icons/tavern_gamble.png')?>" alt="Gamble" width="32" height="32">Gamble</a>
</section>

<div id="msg"></div>

<p>
	These items are bought for you and <em>all</em> your crew members. Therefore, the price will depend on
	the number of crew members.
</p>

<section class="actions">
	<a class="ajaxJSON largepic" title="Buy dinners for you and your crew members" href="<?php echo base_url('tavern/buy_post/dinners')?>">
		<img src="<?php echo base_url('assets/images/icons/tavern_dinner.jpg')?>" title="Increases your crew members health by +25 and their mood by +3">
		Dinners<br><?php echo floor($prices['tavern_dinners']['buy'] * ($game['crew_members'] + 1))?> dbl
	</a>
	
	<a class="ajaxJSON largepic" title="Buy wenches for you and your crew members" href="<?php echo base_url('tavern/buy_post/wenches')?>">
		<img src="<?php echo base_url('assets/images/icons/tavern_wench.jpg')?>" title="Increases your crew members health by +10 and their mood by +5.">
		Wenches<br><?php echo floor($prices['tavern_wenches']['buy'] * ($game['crew_members'] + 1))?> dbl
	</a>
	
	<a class="ajaxJSON largepic" title="Buy wine for you and your crew members" href="<?php echo base_url('tavern/buy_post/wine')?>">
		<img src="<?php echo base_url('assets/images/icons/tavern_wine.jpg')?>" title="Increases your crew members mood by +7.">
		Wine<br><?php echo floor($prices['tavern_wine']['buy'] * ($game['crew_members'] + 1))?> dbl
	</a>
	
	<a class="ajaxJSON largepic" title="Buy rum for you and your crew members" href="<?php echo base_url('tavern/buy_post/rum')?>">
		<img src="<?php echo base_url('assets/images/icons/tavern_rum.jpg')?>" title="Increases your crew members mood by +10.">
		Rum<br><?php echo floor($prices['tavern_rum']['buy'] * ($game['crew_members'] + 1))?> dbl
	</a>
</section>