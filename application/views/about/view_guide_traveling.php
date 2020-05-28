<header title="Guide: Traveling">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Traveling</h2>
		
		<form id="register" method="post" action="<?php echo base_url('account/register_temp')?>">
			<fieldset>
				<legend>Start playing right now...</legend>
							
				<section id="register_left">
					<div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
						<input type="hidden" id="character_avatar" name="character_avatar" value="<?php echo $character['character_avatar']?>">
						<input type="hidden" id="character_gender" name="character_gender" value="<?php echo $character['character_gender']?>">

						<img id="current_avatar_img" style="border: 1px black solid;" src="<?php echo $character['character_avatar_path']?>" alt="Avatar"><br>
						<button type="button" id="js-start-avatar-selector-trigger">Change</button>
					</div>

					<label for="character_name">Character name</label>
					<input id="character_name" type="text" name="character_name" value="<?php echo $character['character_name']?>">
					
					<label for="character_age">Character age</label>
					<input id="character_age" type="number" min="15" max="80" style="width: 50px;" name="character_age" value="<?php echo $character['character_age']?>"><br>

					<a class="ajaxJSON" href="<?php echo base_url('account/generate_character')?>" title="Generate random character"><img src="<?php echo base_url('assets/images/icons/tavern_gamble.png')?>" alt="Random" style="padding: 1em"></a><br>
				</section>
				
				<section id="register_right">
					<input type="submit" value="Play!">
				</section>
			</fieldset>
		</form>

	<?php else: ?>
		<h3>Guide: Traveling</h3>
	<?php endif; ?>
</header>

<section class="action-buttons">
	<?php if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?php echo base_url('about/presentation')?>"><img src="<?php echo base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?php echo base_url('about/guide_supplies')?>"><img src="<?php echo base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?php echo base_url('about/news')?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?php echo base_url('about/ideas')?>"><img src="<?php echo base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
</section>

<div class="divider"></div>

<section class="action-buttons">
	<a class="ajaxHTML" title="About food, water, and other stuff" href="<?php echo base_url('about/guide_supplies')?>"><img src="<?php echo base_url('assets/images/icons/food.png')?>" alt="Supplies" width="32" height="32">Supplies</a>
	<a class="ajaxHTML" title="About ships and gun power" href="<?php echo base_url('about/guide_ships')?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Ships" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="About crew and how to please them" href="<?php echo base_url('about/guide_crew')?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
	<a class="ajaxHTML" title="About titles, levels and ranks" href="<?php echo base_url('about/guide_titles')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_governor.png')?>" alt="Titles" width="32" height="32">Titles</a>
	<a class="ajaxHTML" title="About money and banking" href="<?php echo base_url('about/guide_economy')?>"><img src="<?php echo base_url('assets/images/icons/bank.png')?>" alt="Economy" width="32" height="32">Economy</a>
	<a class="ajaxHTML" title="About travling and sea battles" href="<?php echo base_url('about/guide_traveling')?>"><img src="<?php echo base_url('assets/images/icons/travel.png')?>" alt="Travling" width="32" height="32">Traveling</a>
	<a class="ajaxHTML" title="About other players and how to interact with them" href="<?php echo base_url('about/guide_players')?>"><img src="<?php echo base_url('assets/images/icons/players.png')?>" alt="Players" width="32" height="32">Players</a>
	<a class="ajaxHTML" title="About settings and anonymity" href="<?php echo base_url('about/guide_settings')?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Settings" width="32" height="32">Settings</a>
</section>

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
	<img src="<?php echo base_url()?>assets/images/spanish_main.jpg" alt="Spanish main" style="margin: 20px 10px 10px 20px; border: 3px solid rgb(163, 162, 126);">
</p>

<p>You can visit which of these you want, no matter which nationality you belongs to. This can change in the future...</p>

<h3>Time</h3>

<p>Time is measured in weeks in <?php echo $this->config->item('site_name')?>. The time won't go by itself, but depends on your activity in the game.
A week will pass when you travel from a town to the Caribbean Sea, and when you are working.</p>

<p>It's primarily a method of seeing how active a player is, and to separate the logs in a logical way.</p>

<h3>Battles at sea</h3>

<p>You will find ships from England, France, Spain and Holland. You will also find some pirates, these will always attack you.
Your enemies will probably attack you too, and you can always choose to flee. This can fail sometimes, and the procedure will be the same
as an ordinary attack. So you can lose. You will find more English ships around English towns, so if you want to get a higher level,
travel to your enemies coasts.</p>

<p style="text-align: center;">
	<img src="<?php echo base_url()?>assets/images/design/about_attack.jpg" alt="Attack" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<p>I would suggest that you don't attack ships that have more cannons than you have. The is a random factor here, so you can win if the gap
isn't to big. But it's really risky! It's the amount of functional cannons that decides if you will lose or not.</p>

<p>The fights aren't interactive yet, so you will directly see if you won or lost. You will get a report on how much you won or lost during
the battle. And if you win, you will be able to chose how much you want to loot from the other ship.</p>

<p style="text-align: center;">
	<img src="<?php echo base_url()?>assets/images/design/about_won.jpg" alt="Won" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<h3>Trading at sea</h3>

<p>When you meet ships from your own nation, you can trade with them. You will trade away your barter goods that you don't have any use for,
for food and water, which make it possible to travel for a longer period of time.</p>

<p>Depending on how much food and water you are choosing to take, you pay this of with porcelain, spices and silk first, because you cannot use this
for anything but trading anyway. If that's not enough, you will also trade away medicine, tobacco and rum which could be used to please your crew instead.</p>

<div
	id="js-start-avatar-selector-dialog"
	class="dialog"
	tabindex="-1"
	role="dialog"
	data-url="<?php echo base_url('account/avatar_selector/')?>/<?php echo $character['character_gender_long']?>"
	>
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>
