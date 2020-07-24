<?php
    $sailors_disabled = isset($game['event']['tavern_sailors']['banned']) && $game['event']['tavern_sailors']['banned'] ? 'disabled' : '';
?>

<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/gamble_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Buy something to eat or drink"
			href="<?=base_url('tavern')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#icon-rum"></use>
			</svg>
			Buy
		</a>
		<a id="actions_sailors" <?=$sailors_disabled?>
			class="ajaxHTML
			button big-icon" title="Talk to the sailors at the bar"
			href="<?=base_url('tavern/sailors')?>">
			<svg width="32" height="32" alt="Sailors">
				<use xlink:href="#icon-pirate"></use>
			</svg>
			Sailors
		</a>
		<a class="ajaxHTML button big-icon" title="Gamble for gold!"
			href="<?=base_url('tavern/dice')?>">
			<svg width="32" height="32" alt="Dice">
				<use xlink:href="#icon-dices"></use>
			</svg>
			Dice
		</a>
		<a class="ajaxHTML button big-icon" title="Play black jack"
			href="<?=base_url('tavern/blackjack')?>">
			<svg width="32" height="32" alt="Black Jack">
				<use xlink:href="#icon-cards"></use>
			</svg>
			Black Jack
		</a>
	</div>

	<p>
		Here you can gamble with dices! There is 1/6 chance that you should win, and the prize depends. If you are lucky
		you
		may even win the jackpot!
	</p>

	<form class="ajaxJSON" method="post"
		action="<?=base_url()?>tavern/dice_post">
		<input type="hidden" name="current_money" id="current_money"
			value="<?=$game['doubloons']?>">
		<input type="hidden" name="last_bet" id="last_bet"
			value="<?=$viewdata['next_bet']?>">

		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Gamble">
					<use xlink:href="#icon-dices"></use>
				</svg>
				Gamble with dices
			</legend>

			<div class="slider-container">
				<div id="gamble-slider" class="slider"></div>

				<table>
					<tr>
						<td>Bet</td>
						<td><span id="bet_presenter"><?=$viewdata['next_bet']?></span>
							dbl</td>
					</tr>
					<tr>
						<td>Doubloons left if you lose</td>
						<td><span class="money_left"><?=$game['doubloons'] - $viewdata['next_bet']?></span>
							dbl</td>
					</tr>
					<input type="hidden" id="bet" name="bet"
						value="<?=$viewdata['next_bet']?>">
				</table>
			</div>
		</fieldset>

		<p style="text-align: right;">
			<button type="button" class="js-tavern-bet-set mt-1" data-value="10">10%</button>
			<button type="button" class="js-tavern-bet-set mt-1" data-value="25">25%</button>
			<button type="button" class="js-tavern-bet-set mt-1" data-value="50">50%</button>
			<button type="button" class="js-tavern-bet-set mt-1" data-value="75">75%</button>
			<button type="button" class="js-tavern-bet-set mt-1" data-value="100">100%</button>

			<button type="submit" class="primary mt-1">Gamble</button>
		</p>
	</form>
</div>