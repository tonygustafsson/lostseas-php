<?php if (! $logged_in): ?>
<header class="area-header" class="area-header" title="Guide: Ships">
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Guide: Ships</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
</header>
<?php else: ?>
<div class="container">
	<h3>Guide: Ships</h3>
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

	<h3>The need for ships</h3>

	<img src="<?=base_url()?>assets/images/design/about_shipyard.jpg"
		alt="Shipyard" align="right" style="margin: 20px 10px 10px 20px; border: 3px solid rgb(163, 162, 126);">

	<p>If you lose in battle, and only have one ship you would have to swim to land with nothing at all (if you don't
		have
		any rafts).
		If you don't have any money at your bank account you will have to take a loan, or maybe reset the game and start
		over. Not fun at all!</p>

	<p>The second reason is that you will only lose part of your goods when loosing, if you have more than one ship. If
		you
		have three ships,
		you will lose one third of your goods. They will still take all your money though...</p>

	<p>The third reason is that a ship can only hold so many crew members, cannons and load. If you want to get more
		money,
		higher titles,
		you will need more crew members and cannons. This is not possible with one ship.</p>

	<p>When you start out as a pirate, you will only be able to own three ships. But as your rank get higher, you will
		be
		able to own 15 ships.</p>

	<h3>Different ship types</h3>

	<table style="padding-bottom: 20px;">
		<tr>
			<th>Type</th>
			<th>Min crew</th>
			<th>Max crew</th>
			<th>Max cannons</th>
			<th>Max load</th>
		</tr>
		<tr>
			<td>Brig</td>
			<td>2</td>
			<td>20</td>
			<td>10</td>
			<td>500 cartons</td>
		</tr>
		<tr>
			<td>Merchantman</td>
			<td>1</td>
			<td>10</td>
			<td>0</td>
			<td>1000 cartons</td>
		</tr>
		<tr>
			<td>Galleon</td>
			<td>4</td>
			<td>50</td>
			<td>25</td>
			<td>300 cartons</td>
		</tr>
		<tr>
			<td>Frigate</td>
			<td>8</td>
			<td>100</td>
			<td>50</td>
			<td>600 cartons</td>
		</tr>
	</table>

	<h3>Cannons</h3>

	<p>Cannons are needed for battles at sea. It's the amount of cannons that controls if you win or lose, and also how
		powerful ships
		you will meet. You will need two crew members to control one cannon, which means that if you have 20 cannons,
		and 30
		crew members,
		you will still only be able to use 15 of them.</p>

	<h3>Rafts</h3>

	<p>Rafts are used to save your life when you lose and only had one ship. One raft can save 10 crew members.</p>

	<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
		data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
		<h3 class="dialog-title">Choose an avatar</h3>
		<div class="avatar-selector-wrapper"></div>
	</div>
</div>