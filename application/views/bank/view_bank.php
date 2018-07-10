<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/bank_' . $game['nation'] . '.jpg')?>" class="header" alt="The bank">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Transfer money to and from your bank account" href="bank"><img src="<?php echo base_url('assets/images/icons/money_bank.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Take or pay back a loan" href="bank/loan"><img src="<?php echo base_url('assets/images/icons/money_bank_loan.png')?>" alt="Loans" width="32" height="32">Loans</a>
</section>

<p>
	<?php echo $game['greeting']?>
</p>

<p>
	Here you can put your money in you bank account, or take it out. You will access the same money in all
	towns, wherever you are. It will cost you some, but you won't lose your money in battle.
</p>

<p><strong>The bank will keep 5 percent of what you put in your account...</strong></p>

<div id="msg"></div>

<form method="post" class="ajaxJSON" id="transfer_form" action="<?php echo base_url('bank/account_post')?>">
	<input type="hidden" name="current_money" id="current_money" value="<?php echo $game['doubloons']?>">
	<input type="hidden" name="current_money_bank" id="current_money_bank" value="<?php echo $game['bank_account']?>">
	
	<fieldset>
		<legend><img src="<?php echo base_url('assets/images/icons/bank.png')?>" alt="Bank Account" width="32" height="32"> Bank account</legend>
		<div id="account-slider" style="width: 90%; margin: 20px;"></div>

		<table style="margin: 0 auto; width: 90%">
			<tr><td>Transfer</td><td><span id="transfer_presenter">0</span> dbl</td></tr>
			<tr><td>Doubloons (Cash)</td><td><span class="money_after"><?php echo $game['doubloons']?></span> dbl</td></tr>
			<tr><td>Account</td><td><span class="account_after"><?php echo $game['bank_account']?></span> dbl</td></tr>
		</table>
		<input type="hidden" name="transfer" id="transfer" value="0">
	</fieldset>

	<p style="text-align: right;">
		<button type="button" onclick="return bankAccountReset()">Reset</button>
		<input type="submit" value="Transfer">
	</p>
</form>