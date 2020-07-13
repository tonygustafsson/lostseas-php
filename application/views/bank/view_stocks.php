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
		Stocks will go up or down in value each week. There is a 2/3 chance that it will go up.
		Different stocks have different volatility and cost.
		You will get your money back when you sell your stocks. You can own a maximum of 10 stocks.
	</p>

	<?php if (count($game['stocks']) > 0): ?>
	<h3>Your stocks</h3>

	<div class="table-responsive">
		<table>
			<tr>
				<th>Name</th>
				<th>Cost</th>
				<th>Value</th>
				<th>Earnings</th>
			</tr>
			<?php foreach ($game['stocks'] as $stock): ?>
			<tr>
				<td>
					<a href="#"
						data-stock-id="<?=$stock['id']?>">
						<?=$stock['name']?>
					</a>
				</td>
				<td><?=$stock['cost']?>
				</td>
				<td><?=$stock['value']?>
				</td>
				<td>
					<?php if ($stock['value'] >= $stock['cost']): ?>
					+<?=($stock['cost'] / $stock['value']) * 100 - 100?>%
					<?php else: ?>
					-<?=($stock['cost'] / $stock['value']) * 100 - 100?>%
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
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