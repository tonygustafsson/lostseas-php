<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<? endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/sailors_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Buy something to eat or drink" href="tavern"><img src="<?php echo base_url('assets/images/icons/tavern_buy.png')?>" alt="Buy" width="32" height="32">Buy</a>
	<? if ($game['event_sailors'] != 'banned'): ?>
		<a id="actions_sailors" class="ajaxHTML" title="Talk to the sailors at the bar" href="<?php echo base_url('tavern/sailors')?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Sailors" width="32" height="32">Sailors</a>
	<? endif; ?>
	<a class="ajaxHTML" title="Gamble for gold!" href="tavern/gamble"><img src="<?php echo base_url('assets/images/icons/tavern_gamble.png')?>" alt="Gamble" width="32" height="32">Gamble</a>
</section>

<div id="msg"></div>

<? if (! empty($game['event_sailors']) && is_numeric($game['event_sailors'])): ?>
	<section id="offer">
		<p>You talk to <?php echo $game['event_sailors']?> sailors. After a while they decides to join your crew. Do you want to take them in?</p>

		<section class="actions">
			<a href="tavern/sailors_post/yes" class="ajaxJSON nopic positive" title="Take these sailors in!">Yes</a>
			<a href="tavern/sailors_post/no" class="ajaxJSON nopic negative" title="Tell them to mind their own business">No</a>
		</section>
	</section>
<? endif; ?>