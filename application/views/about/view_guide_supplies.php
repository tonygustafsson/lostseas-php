<header class="area-header" class="area-header" title="Guide: Supplies">
	<?php if (! $logged_in): ?>
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Guide: Supplies</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>

	<?php else: ?>
	<h3>Guide: Supplies</h3>
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

<h3>Buying and selling</h3>
<img src="<?=base_url()?>assets/images/design/about_shop.jpg"
	alt="Shop" align="right" style="margin: 20px 20px 10px 10px; border: 3px solid rgb(163, 162, 126);">

<p>At the shop you can buy and sell everything your crew needs to be strong and healthy. For the most part you just want
	to
	buy food and water, and maybe sell of some barter goods. There are some goods that have no use but trading.</p>

<p>The market is a bit different... here you will get an offer, that is almost always cheaper than the shop. But you
	cannot control how much
	of it you want, and if you cannot afford it; it will be a deal breaker. It's a good idea to visit sometimes, buy
	some barter goods and sell
	it of at the store the moment after.</p>

<h3>Food and water</h3>

<p>You and your crew will need both food and water for traveling at sea. A half carton of food and a whole barrel of
	water for every crew member,
	including yourself, per week. You and your crew won't die however, but they will refuse to travel any longer. When
	this happens, you need to
	land your ship at the closest harbor and buy more at the shop.</p>

<h3>Tobacco and rum</h3>

<p>You won't <em>need</em> these, but it can come handy. Tobacco will raise your crew mood by 1 and rum will raise it by
	3. You can give your
	crew these products by clicking in the inventory, choose which users to please, and choose which product to use, and
	click "Do it!".

<p style="text-align: center;">
	<img src="<?=base_url()?>assets/images/design/about_rum.jpg"
		alt="Rum" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<h3>Medicine</h3>

<p>
	The same way you can give your crew members tobacco and rum, you can also give them medicine. This will restore
	their health to 100 % and it
	can be used everywhere. There is a healer at the market, who is cheaper than using medicine, but you aren't always
	at a town. Besides,
	you will loot medicine from enemy ships anyway.
</p>

<h3>Barter goods</h3>

<p>This includes porcelain, spices and silk. You don't have any use of these goods, but you will loot a lot of these at
	sea. You can them sell
	them at the shop and make money that way.</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>