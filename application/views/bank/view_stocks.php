<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/bank_' . $game['nation'] . '.png')?>"
		class="area-header__img" alt="The bank">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Transfer money to and from your bank account"
			href="<?=base_url('bank')?>">
			<svg width="32" height="32" alt="Savings">
				<use xlink:href="#savings"></use>
			</svg>
			Account
		</a>
		<a class="ajaxHTML button big-icon" title="Take or pay back a loan"
			href="<?=base_url('bank/loan')?>">
			<svg width="32" height="32" alt="Loan">
				<use xlink:href="#loan"></use>
			</svg>
			Loans
		</a>
		<a class="ajaxHTML button big-icon" title="Take or pay back a loan"
			href="<?=base_url('bank/stocks')?>">
			<svg width="32" height="32" alt="Stocks">
				<use xlink:href="#stocks"></use>
			</svg>
			Stocks
		</a>
	</div>

	<p>
		Stocks will go up or down in value each week. There is a bigger chance that it will go up than down.
		Different stocks have different volatility and cost. There will be a buying fee of 2%.
		You will get your money back when you sell your stocks. You can own a maximum of 10 stocks.
	</p>

	<?php if (count($game['stocks']) > 0): ?>
	<h3>Your stocks</h3>

	<div class="table-responsive">
		<table>
			<tr>
				<th>Name</th>
				<th>Cost</th>
				<th>Worth</th>
				<th>Earnings</th>
			</tr>
			<?php foreach ($game['stocks'] as $stock_id => $stock): ?>
			<tr>
				<td>
					<a href="#" class="js-trigger-stock-info"
						id="js-stock-info-trigger-<?=$stock_id?>"
						data-stock-id="<?=$stock_id?>">
						<?=$stock['name']?>
					</a>
				</td>
				<td><?=$stock['cost']?>
				</td>
				<td><?=$stock['worth']?>
				</td>
				<td>
					<?php if ($stock['worth'] >= $stock['cost']): ?>
					<?=round((($stock['worth'] - $stock['cost']) / $stock['cost']) * 100)?>%
					<?php else: ?>
					<?=0 - round((($stock['cost'] - $stock['worth']) / $stock['cost']) * 100)?>%
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>

	<?php foreach ($game['stocks'] as $stock_id => $stock): ?>
	<div id="js-stock-info-<?=$stock_id?>" class="dialog"
		tabindex="-1" role="dialog">
		<h3 class="dialog-title"><?=$stock['name']?>
		</h3>

		<div class="flex pt-1">
			<div style="flex: 1 0 25%">
				<svg width="100" height="100" class="w-100">
					<use xlink:href="#stocks"></use>
				</svg>
			</div>
			<div>
				<p class="mt-0"><?=$viewdata['items'][$stock['name_id']]['description']?>
				</p>
			</div>
		</div>

		<table>
			<tr>
				<td>Current worth</td>
				<td><?=$stock['worth']?>
				</td>
			</tr>
			<tr>
				<td>Original cost</td>
				<td><?=$stock['cost']?>
				</td>
			</tr>
			<tr>
				<td>Earnings</td>
				<td>
					<?php if ($stock['worth'] >= $stock['cost']): ?>
					<?=round((($stock['worth'] - $stock['cost']) / $stock['cost']) * 100)?>%
					<?php else: ?>
					<?=0 - round((($stock['cost'] - $stock['worth']) / $stock['cost']) * 100)?>%
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td>Bought</td>
				<td>
					<?php if ($stock['week'] < $game['week']): ?>
					<?=$game['week'] - $stock['week']?>
					weeks ago (week <?=$stock['week']?>)
					<?php else: ?>
					This week (week <?=$stock['week']?>)
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td>Volatility</td>
				<td><?=$stock['volatility']?>%
				</td>
			</tr>
		</table>
	</div>
	<?php endforeach; ?>

	<a href="<?=base_url('bank/update_stocks_worth')?>"
		class="ajaxJSON">Update stock worth</a>
	<?php else: ?>
	<p><em>You do not currently own any stocks.</em></p>
	<?php endif; ?>

	<h3>Buy stocks</h3>

	<div class="button-area">
		<?php foreach ($viewdata['items'] as $item): ?>
		<a class="ajaxJSON button big-image tooltip-bottom-center"
			data-tooltip="<?=$item['description']?>"
			href="<?=$item['link']?>">
			<svg width="32" height="32">
				<use xlink:href="#stocks"></use>
			</svg>
			<?=$item['name']?>
			<br />
			<?=$item['cost']?>
			dbl (+-<?=$item['volatility']?>%)
		</a>
		<?php endforeach; ?>
	</div>
</div>