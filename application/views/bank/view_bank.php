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
	</div>

	<p>
		<?=$game['greeting']?>
	</p>

	<p>
		Here you can put your money in you bank account, or take it out. You will access the same money in all
		towns, wherever you are. It will cost you some, but you won't lose your money in battle.
	</p>

	<p><strong>The bank will keep 5 percent of what you put in your account...</strong></p>

	<form method="post" class="ajaxJSON" id="transfer_form"
		action="<?=base_url('bank/account_post')?>">
		<input type="hidden" name="current_money" id="current_money"
			value="<?=$game['doubloons']?>">
		<input type="hidden" name="current_money_bank" id="current_money_bank"
			value="<?=$game['bank_account']?>">
		<input type="hidden" name="transfer" id="transfer" value="0">

		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Savings">
					<use xlink:href="#savings"></use>
				</svg>
				Bank account
			</legend>

			<div class="slider-container">
				<div id="account-slider" class="slider"></div>

				<table>
					<tr>
						<td>Transfer</td>
						<td><span id="transfer_presenter">0</span> dbl</td>
					</tr>
					<tr>
						<td>Doubloons (Cash)</td>
						<td><span class="money_after"><?=$game['doubloons']?></span>
							dbl</td>
					</tr>
					<tr>
						<td>Account</td>
						<td><span class="account_after"><?=$game['bank_account']?></span>
							dbl</td>
					</tr>
				</table>
			</div>
		</fieldset>

		<p style="text-align: right;">
			<button type="button" class="js-bank-account-reset">Reset</button>
			<button class="primary" type="submit">Transfer</button>
		</p>
	</form>
</div>