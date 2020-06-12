<header class="area-header" class="area-header" title="Guide: Titles">
	<?php if (! $logged_in): ?>
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Guide: Titles</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>

	<?php else: ?>
	<h3>Guide: Titles</h3>
	<?php endif; ?>
</header>

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

<h3>Nations</h3>
<p>This game takes place at the Spanish Main, in the Caribbean Sea at the 1600th. There are four nations, battling over
	the towns.
	English, French, Spanish and Dutch.</p>

<h3>Levels</h3>
<img src="<?=base_url()?>assets/images/design/about_governor.jpg"
	alt="Governor" align="right" style="margin: 20px 20px 10px 10px; border: 3px solid rgb(163, 162, 126);">

<p>The level system in this game is pretty simple. You belong to a nation, and for every ship you win over from that
	nations enemy will raise your
	level by 1. And if you fight your own nations ships it will be lowered by the same amount. Winning over neutral
	ships doesn't change your level, but
	it still meaningful to loot some gold from them.</p>

<h3>Titles</h3>

<p>Levels doesn't do anything by itself, but you will be judged by the nations governor (At the City Hall) by it. You
	will get promoted if you
	are doing a good job. You will then get a reward, and higher titles will let you own more ships, which in turn give
	access to more crew members,
	cannons and being able to load more goods. Some would say that the main goal of this game (if you need any) is to
	reach the highest title.</p>

<h3>The different titles</h3>
<table style="padding: 1em;">
	<tr>
		<th>Level</th>
		<th>Title</th>
		<th>Reward</th>
		<th>Max ships</th>
	</tr>

	<tr>
		<td>0-9</td>
		<td>Pirate</td>
		<td>No reward</td>
		<td>3</td>
	</tr>

	<tr>
		<td>10-19</td>
		<td>Ensign</td>
		<td>1000 dbl</td>
		<td>5</td>
	</tr>

	<tr>
		<td>20-29</td>
		<td>Captain</td>
		<td>2500 dbl</td>
		<td>6</td>
	</tr>

	<tr>
		<td>30-39</td>
		<td>Major</td>
		<td>4000 dbl</td>
		<td>7</td>
	</tr>

	<tr>
		<td>40-49</td>
		<td>Colonel</td>
		<td>6000 dbl</td>
		<td>8</td>
	</tr>

	<tr>
		<td>50-64</td>
		<td>Admiral</td>
		<td>8000 dbl</td>
		<td>10</td>
	</tr>

	<tr>
		<td>65-79</td>
		<td>Baron</td>
		<td>10 000 dbl</td>
		<td>11</td>
	</tr>

	<tr>
		<td>80-99</td>
		<td>Count</td>
		<td>15 000 dbl</td>
		<td>12</td>
	</tr>

	<tr>
		<td>100-119</td>
		<td>Marquis</td>
		<td>20 000 dbl</td>
		<td>13</td>
	</tr>

	<tr>
		<td>120+</td>
		<td>Duke</td>
		<td>35 000 dbl</td>
		<td>15</td>
	</tr>

</table>

<h3>Changing nation</h3>

<p>If you are not pleased by your nation you can actually change it. You do this by attacking the enemy of the nation
	you want to be a
	citizen of. So if you want to be English, attack a lot of French ships! When you have won over more French ships
	than over English ships
	you can buy yourself a citizenship. The title you receive depends on your level (which depends on how many more
	French ships than English ships
	you have destroyed).</p>

<p>Just to make things clear: If you are a Spanish citizen and have attacked 50 French ships even though this isn't your
	enemy, and you have
	not attacked any English ships, you will be an english Admiral at once when you buy yourself an english citizenship.
</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>