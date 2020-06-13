<?php if (! $logged_in): ?>
<header class="area-header" class="area-header" title="Guide: Traveling">
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Guide: Traveling</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
</header>
<?php else: ?>
<div class="container">
	<h3>Guide: Traveling</h3>
</div>
<?php endif; ?>

<div class="container">
	<div class="button-area">
		<?php if (!$logged_in): ?>
		<a class="ajaxHTML button big-icon" title="Presentation about the game"
			href="<?=base_url('about/presentation')?>">
			<svg width="32" height="32" class="Start">
				<use xlink:href="#swords"></use>
			</svg>
			Start
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon" title="A complete guide for this game"
			href="<?=base_url('about/guide_supplies')?>">
			<svg width="32" height="32" class="Guide">
				<use xlink:href="#logbook"></use>
			</svg>
			Guide
		</a>
		<a class="ajaxHTML button big-icon" title="What's new in here?"
			href="<?=base_url('about/news')?>">
			<svg width="32" height="32" class="News">
				<use xlink:href="#magazine"></use>
			</svg>
			News
		</a>
	</div>

	<div class="divider"></div>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="About food, water, and other stuff"
			href="<?=base_url('about/guide_supplies')?>">
			<svg width="32" height="32" alt="Food">
				<use xlink:href="#barrels"></use>
			</svg>
			Supplies
		</a>
		<a class="ajaxHTML button big-icon" title="About ships and gun power"
			href="<?=base_url('about/guide_ships')?>">
			<svg width="32" height="32" alt="Ships">
				<use xlink:href="#ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon" title="About crew and how to please them"
			href="<?=base_url('about/guide_crew')?>">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon" title="About titles, levels and ranks"
			href="<?=base_url('about/guide_titles')?>">
			<svg width="32" height="32" alt="Titles">
				<use xlink:href="#governor"></use>
			</svg>
			Titles
		</a>
		<a class="ajaxHTML button big-icon" title="About money and banking"
			href="<?=base_url('about/guide_economy')?>">
			<svg width="32" height="32" alt="Economy">
				<use xlink:href="#doubloons"></use>
			</svg>
			Economy
		</a>
		<a class="ajaxHTML button big-icon" title="About travling and sea battles"
			href="<?=base_url('about/guide_traveling')?>">
			<svg width="32" height="32" alt="Traveling">
				<use xlink:href="#compass"></use>
			</svg>
			Traveling
		</a>
		<a class="ajaxHTML button big-icon" title="About other players and how to interact with them"
			href="<?=base_url('about/guide_players')?>">
			<svg width="32" height="32" alt="Players">
				<use xlink:href="#player"></use>
			</svg>
			Players
		</a>
		<a class="ajaxHTML button big-icon" title="About settings and anonymity"
			href="<?=base_url('about/guide_settings')?>">
			<svg width="32" height="32" alt="Settings">
				<use xlink:href="#cogs"></use>
			</svg>
			Settings
		</a>
	</div>

	<div class="divider"></div>

	<h3>Towns and nations</h3>

	<p>
		The english towns are: Charles Towne, Barbados, Port Royale and Belize.<br>
		The french towns are: Tortuga, Leogane, Martinique and Biloxi.<br>
		The spanish towns are: Panama, Havana, Villa Hermosa and San Juan.<br>
		The dutch towns are: Bonaire, Curacao, St. Martin and St. Eustatius.
	</p>

	<p>All these towns actually existed in the 1600th. The towns nationality varied from year to year though.</p>

	<p style="text-align: center;">
		<img src="<?=base_url()?>assets/images/spanish_main.jpg"
			alt="Spanish main" style="margin: 20px 10px 10px 20px; border: 3px solid rgb(163, 162, 126);">
	</p>

	<p>You can visit which of these you want, no matter which nationality you belongs to. This can change in the
		future...
	</p>

	<h3>Time</h3>

	<p>Time is measured in weeks in <?=$this->config->item('site_name')?>. The time
		won't go by itself, but depends on your activity in the game.
		A week will pass when you travel from a town to the Caribbean Sea, and when you are working.</p>

	<p>It's primarily a method of seeing how active a player is, and to separate the logs in a logical way.</p>

	<h3>Battles at sea</h3>

	<p>You will find ships from England, France, Spain and Holland. You will also find some pirates, these will always
		attack you.
		Your enemies will probably attack you too, and you can always choose to flee. This can fail sometimes, and the
		procedure will be the same
		as an ordinary attack. So you can lose. You will find more English ships around English towns, so if you want to
		get
		a higher level,
		travel to your enemies coasts.</p>

	<p style="text-align: center;">
		<img src="<?=base_url()?>assets/images/design/about_attack.jpg"
			alt="Attack" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
	</p>

	<p>I would suggest that you don't attack ships that have more cannons than you have. The is a random factor here, so
		you
		can win if the gap
		isn't to big. But it's really risky! It's the amount of functional cannons that decides if you will lose or not.
	</p>

	<p>The fights aren't interactive yet, so you will directly see if you won or lost. You will get a report on how much
		you
		won or lost during
		the battle. And if you win, you will be able to chose how much you want to loot from the other ship.</p>

	<p style="text-align: center;">
		<img src="<?=base_url()?>assets/images/design/about_won.jpg"
			alt="Won" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
	</p>

	<h3>Trading at sea</h3>

	<p>When you meet ships from your own nation, you can trade with them. You will trade away your barter goods that you
		don't have any use for,
		for food and water, which make it possible to travel for a longer period of time.</p>

	<p>Depending on how much food and water you are choosing to take, you pay this of with porcelain, spices and silk
		first,
		because you cannot use this
		for anything but trading anyway. If that's not enough, you will also trade away medicine, tobacco and rum which
		could be used to please your crew instead.</p>

	<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
		data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
		<h3 class="dialog-title">Choose an avatar</h3>
		<div class="avatar-selector-wrapper"></div>
	</div>
</div>