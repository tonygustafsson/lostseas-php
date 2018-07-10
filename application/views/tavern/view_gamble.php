<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/gamble_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Buy something to eat or drink" href="tavern"><img src="<?php echo base_url('assets/images/icons/tavern_buy.png')?>" alt="Buy" width="32" height="32">Buy</a>
	<?php if ($game['event_sailors'] != 'banned'): ?>
		<a id="actions_sailors" class="ajaxHTML" title="Talk to the sailors at the bar" href="<?php echo base_url('tavern/sailors')?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Sailors" width="32" height="32">Sailors</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Gamble for gold!" href="tavern/gamble"><img src="<?php echo base_url('assets/images/icons/tavern_gamble.png')?>" alt="Gamble" width="32" height="32">Gamble</a>
</section>

<p>
	Here you can gamble with dices! There is 1/6 chance that you should win, and the prize depends. If you are lucky you may even win the jackpot!
</p>

<div id="msg"></div>

<form class="ajaxJSON" method="post" action="<?php echo base_url()?>tavern/gamble_post">
	<input type="hidden" name="current_money" id="current_money" value="<?php echo $game['doubloons']?>">
	<input type="hidden" name="last_bet" id="last_bet" value="<?php echo $game['next_bet']?>">
	
	<fieldset>
		<legend><img src="<?php echo base_url()?>assets/images/icons/tavern_gamble.png" alt="Gamble" width="32" height="32"> Gamble with dices</legend>
		<div id="gamble-slider" style="width: 90%; margin: 20px;"></div>
		<table style="margin: 0 auto; width: 90%">
			<tr><td>Bet</td><td><span id="bet_presenter"><?php echo $game['next_bet']?></span> dbl</td></tr>
			<tr><td>Doubloons left if you lose</td><td><span class="money_left"><?php echo $game['doubloons'] - $game['next_bet']?></span> dbl</td></tr>
			<input type="hidden" id="bet" name="bet" value="<?php echo $game['next_bet']?>">
		</table>
	
	</fieldset>
	
	<p style="text-align: right;">
		<button type="button" onclick="return tavernGambleSet(10);">10%</button>
		<button type="button" onclick="return tavernGambleSet(25);">25%</button>
		<button type="button" onclick="return tavernGambleSet(50);">50%</button>
		<button type="button" onclick="return tavernGambleSet(75);">75%</button>
		<input type="submit" value="Gamble!">
	</p>

</form>