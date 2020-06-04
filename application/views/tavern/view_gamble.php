<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/gamble_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Buy something to eat or drink" href="tavern"><img src="<?=base_url('assets/images/icons/tavern_buy.png')?>" alt="Buy" width="32" height="32">Buy</a>
	<?php if ($game['event_sailors'] != 'banned'): ?>
		<a id="actions_sailors" class="ajaxHTML" title="Talk to the sailors at the bar" href="<?=base_url('tavern/sailors')?>"><img src="<?=base_url('assets/images/icons/tavern_sailor.png')?>" alt="Sailors" width="32" height="32">Sailors</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Gamble for gold!" href="tavern/gamble"><img src="<?=base_url('assets/images/icons/tavern_gamble.png')?>" alt="Gamble" width="32" height="32">Gamble</a>
</section>

<p>
	Here you can gamble with dices! There is 1/6 chance that you should win, and the prize depends. If you are lucky you may even win the jackpot!
</p>

<form class="ajaxJSON" method="post" action="<?=base_url()?>tavern/gamble_post">
	<input type="hidden" name="current_money" id="current_money" value="<?=$game['doubloons']?>">
	<input type="hidden" name="last_bet" id="last_bet" value="<?=$game['next_bet']?>">
	
	<fieldset>
		<legend><img src="<?=base_url()?>assets/images/icons/tavern_gamble.png" alt="Gamble" width="32" height="32"> Gamble with dices</legend>
		
		<div class="slider-container">
			<div id="gamble-slider" class="slider"></div>
			
			<table>
				<tr><td>Bet</td><td><span id="bet_presenter"><?=$game['next_bet']?></span> dbl</td></tr>
				<tr><td>Doubloons left if you lose</td><td><span class="money_left"><?=$game['doubloons'] - $game['next_bet']?></span> dbl</td></tr>
				<input type="hidden" id="bet" name="bet" value="<?=$game['next_bet']?>">
			</table>
		</div>
	</fieldset>
	
	<p style="text-align: right;">
		<button type="button" class="js-tavern-bet-set" data-value="10">10%</button>
		<button type="button" class="js-tavern-bet-set" data-value="25">25%</button>
		<button type="button" class="js-tavern-bet-set" data-value="50">50%</button>
		<button type="button" class="js-tavern-bet-set" data-value="75">75%</button>
		<button type="button" class="js-tavern-bet-set" data-value="100">100%</button>

		<input type="submit" value="Gamble!">
	</p>
</form>