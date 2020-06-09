<header class="area-header" class="area-header" title="Guide: Economy">
	<?php if (! $logged_in): ?>
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Guide: Economy</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
	<?php else: ?>
	<h3>Guide: Economy</h3>
	<?php endif; ?>
</header>

<section class="action-buttons">
	<?php if (!$logged_in): ?>
	<a class="ajaxHTML" title="Presentation about the game"
		href="<?=base_url('about/presentation')?>">
		<svg width="32" height="32" class="Start">
			<use xlink:href="#swords"></use>
		</svg>
		Start
	</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game"
		href="<?=base_url('about/guide_supplies')?>">
		<svg width="32" height="32" class="Guide">
			<use xlink:href="#logbook"></use>
		</svg>
		Guide
	</a>
	<a class="ajaxHTML" title="What's new in here?"
		href="<?=base_url('about/news')?>">
		<svg width="32" height="32" class="News">
			<use xlink:href="#magazine"></use>
		</svg>
		News
	</a>
</section>

<div class="divider"></div>

<section class="action-buttons">
	<a class="ajaxHTML" title="About food, water, and other stuff"
		href="<?=base_url('about/guide_supplies')?>">
		<svg width="32" height="32" alt="Food">
			<use xlink:href="#barrels"></use>
		</svg>
		Supplies
	</a>
	<a class="ajaxHTML" title="About ships and gun power"
		href="<?=base_url('about/guide_ships')?>">
		<svg width="32" height="32" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML" title="About crew and how to please them"
		href="<?=base_url('about/guide_crew')?>">
		<svg width="32" height="32" alt="Crew">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
	<a class="ajaxHTML" title="About titles, levels and ranks"
		href="<?=base_url('about/guide_titles')?>">
		<svg width="32" height="32" alt="Titles">
			<use xlink:href="#governor"></use>
		</svg>
		Titles
	</a>
	<a class="ajaxHTML" title="About money and banking"
		href="<?=base_url('about/guide_economy')?>">
		<svg width="32" height="32" alt="Economy">
			<use xlink:href="#doubloons"></use>
		</svg>
		Economy
	</a>
	<a class="ajaxHTML" title="About travling and sea battles"
		href="<?=base_url('about/guide_traveling')?>">
		<svg width="32" height="32" alt="Traveling">
			<use xlink:href="#compass"></use>
		</svg>
		Traveling
	</a>
	<a class="ajaxHTML" title="About other players and how to interact with them"
		href="<?=base_url('about/guide_players')?>">
		<svg width="32" height="32" alt="Players">
			<use xlink:href="#player"></use>
		</svg>
		Players
	</a>
	<a class="ajaxHTML" title="About settings and anonymity"
		href="<?=base_url('about/guide_settings')?>">
		<svg width="32" height="32" alt="Settings">
			<use xlink:href="#cogs"></use>
		</svg>
		Settings
	</a>
</section>

<div class="divider"></div>

<h3>Getting money</h3>

<p>The currency in this game is doubloons (dbl), for which you can buy and sell almost anything. You will mostly get
	money from looting ships at sea, but you
	can also sell your goods, gamble for it, fight at the bar or just old plain working.</p>

<h3>Saving money</h3>

<img src="<?=base_url('assets/images/design/about_bank.jpg')?>"
	alt="Bank" align="right" style="margin-right: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">

<p>There is a banking system in this game. When you lose a battle at sea, you will lose all your doubloons, no matter
	how many ships you've got.
	It would be impossible to achieve anything if you couldn't save it in a safe place.</p>

<p>You have a bank account that you can put your money into and out of no matter which nation you are in. If you put in
	100 dbl in Panama, you can
	take it out in Port Royale without any trouble.</p>

<p>It's recommended to only have cash when you are in a town, for buying and selling. Before you leave, you should put
	the rest in your account.
	There is however a small tax of 5 %. If you put in 100 dbl, you can only get 95 dbl back.</p>

<h3>Loans</h3>

<p>You can also take a loan if the game are tough on you. You have to pay a rent of 15 % if you do so, and you cannot
	loan more than 11 500 dbl.
	The usual reason to take a loan is when you haven't saved anything in your account and loses a fight at sea.</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>