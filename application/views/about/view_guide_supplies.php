<header title="Guide: Supplies">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Supplies</h2>
		
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
		<h3>Guide: Supplies</h3>
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

<h3>Buying and selling</h3>
<img src="<?php echo base_url()?>assets/images/design/about_shop.jpg" alt="Shop" align="right" style="margin: 20px 20px 10px 10px; border: 3px solid rgb(163, 162, 126);">

<p>At the shop you can buy and sell everything your crew needs to be strong and healthy. For the most part you just want to
buy food and water, and maybe sell of some barter goods. There are some goods that have no use but trading.</p>

<p>The market is a bit different... here you will get an offer, that is almost always cheaper than the shop. But you cannot control how much
of it you want, and if you cannot afford it; it will be a deal breaker. It's a good idea to visit sometimes, buy some barter goods and sell
it of at the store the moment after.</p>

<h3>Food and water</h3>

<p>You and your crew will need both food and water for traveling at sea. A half carton of food and a whole barrel of water for every crew member,
including yourself, per week. You and your crew won't die however, but they will refuse to travel any longer. When this happens, you need to
land your ship at the closest harbor and buy more at the shop.</p>

<h3>Tobacco and rum</h3>

<p>You won't <em>need</em> these, but it can come handy. Tobacco will raise your crew mood by 1 and rum will raise it by 3. You can give your
crew these products by clicking in the inventory, choose which users to please, and choose which product to use, and click "Do it!".

<p style="text-align: center;">
	<img src="<?php echo base_url()?>assets/images/design/about_rum.jpg" alt="Rum" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<h3>Medicine</h3>

<p>
	The same way you can give your crew members tobacco and rum, you can also give them medicine. This will restore their health to 100 % and it
	can be used everywhere. There is a healer at the market, who is cheaper than using medicine, but you aren't always at a town. Besides,
	you will loot medicine from enemy ships anyway.
</p>

<h3>Barter goods</h3>

<p>This includes porcelain, spices and silk. You don't have any use of these goods, but you will loot a lot of these at sea. You can them sell
them at the shop and make money that way.</p>

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
