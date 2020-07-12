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
		<?=$game['greeting']?>
	</p>

	<p>
		Buy stocks.
	</p>
</div>