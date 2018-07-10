<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2 title="bank_account"><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/bank_' . $game['nation'] . '.jpg')?>" class="header" alt="The bank">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Transfer money to and from your bank account" href="bank"><img src="<?php echo base_url('assets/images/icons/money_bank.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Take or pay back a loan" href="bank/loan"><img src="<?php echo base_url('assets/images/icons/money_bank_loan.png')?>" alt="Loans" width="32" height="32">Loans</a>
</section>

<p>
	You can loan up to 10 000 dbl here, with intrest of 15 percent. Which means that you can owe 11 500 to the bank at most.
</p>

<div id="msg"></div>

<form method="post" class="ajaxJSON" id="transfer_form" action="<?php echo base_url('bank/loan_post')?>">
	<input type="hidden" name="current_money" id="current_money" value="<?php echo $game['doubloons']?>">
	<input type="hidden" name="current_money_bank_loan" id="current_money_bank_loan" value="<?php echo $game['bank_loan']?>">
	<fieldset>
		<legend><img src="<?php echo base_url('assets/images/icons/bank.png')?>" alt="Bank Loan" width="32" height="32"> Bank loan</legend>
		<div id="loan-slider" style="width: 90%; margin: 20px;"></div>
		
		<table style="margin: 0 auto; width: 90%">
			<tr><td>Transfer</td><td><span id="transfer_presenter">0</span> dbl</td></tr>
			<tr><td>Doubloons (Cash)</td><td><span class="money_after"><?php echo $game['doubloons']?></span> dbl</td></tr>
			<tr><td>Loan</td><td><span class="loan_after"><?php echo $game['bank_loan']?></span> dbl</td></tr>
			<input type="hidden" name="transfer" id="transfer" value="0">
		</table>
	</fieldset>
	
	<p style="text-align: right;">
		<button type="button" onclick="return bankLoanReset()">Reset</button>
		<input type="submit" value="Transfer">
	</p>
</form>