<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="Guide: Ships">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Ships</h2>
	
		<form id="register" method="post" action="<?php echo base_url('account/register_temp')?>">
			<fieldset>
				<legend>Start playing right now...</legend>
							
				<section id="register_left">
					<div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
						<input type="hidden" id="character_avatar" name="character_avatar" value="<?php echo $character['character_avatar']?>">
						<input type="hidden" id="character_gender" name="character_gender" value="<?php echo $character['character_gender']?>">

						<div id="avatar_selector_div" title="Avatar selector" data-url="<?php echo base_url('account/avatar_selector/')?>/<?php echo $character['character_gender_long']?>"></div>

						<img id="current_avatar_img" style="border: 1px black solid;" src="<?php echo $character['character_avatar_path']?>" alt="Avatar"><br>
						<button type="button" id="change_avatar_button">Change</button>
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
		<h3>Guide: Ships</h3>
	<?php endif; ?>
</header>

<section class="actions">
	<?php if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?php echo base_url('about/presentation')?>"><img src="<?php echo base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?php echo base_url('about/guide_supplies')?>"><img src="<?php echo base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?php echo base_url('about/news')?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?php echo base_url('about/ideas')?>"><img src="<?php echo base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
	<a class="ajaxHTML" title="About web technologies used to create this game" href="<?php echo base_url('about/tech')?>"><img src="<?php echo base_url('assets/images/icons/about_tech.png')?>" alt="Tech" width="32" height="32">Tech</a>
</section>

<div class="divider"></div>

<section class="actions">
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

<h3>The need for ships</h3>

<img src="<?php echo base_url()?>assets/images/design/about_shipyard.jpg" alt="Shipyard" align="left" style="margin: 20px 10px 10px 20px; border: 3px solid rgb(163, 162, 126);">

<p>If you lose in battle, and only have one ship you would have to swim to land with nothing at all (if you don't have any rafts).
If you don't have any money at your bank account you will have to take a loan, or maybe reset the game and start over. Not fun at all!</p>

<p>The second reason is that you will only lose part of your goods when loosing, if you have more than one ship. If you have three ships,
you will lose one third of your goods. They will still take all your money though...</p>

<p>The third reason is that a ship can only hold so many crew members, cannons and load. If you want to get more money, higher titles,
you will need more crew members and cannons. This is not possible with one ship.</p>

<p>When you start out as a pirate, you will only be able to own three ships. But as your rank get higher, you will be able to own 15 ships.</p>

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

<p>Cannons are needed for battles at sea. It's the amount of cannons that controls if you win or lose, and also how powerful ships
you will meet. You will need two crew members to control one cannon, which means that if you have 20 cannons, and 30 crew members,
you will still only be able to use 15 of them.</p>

<h3>Rafts</h3>

<p>Rafts are used to save your life when you lose and only had one ship. One raft can save 10 crew members.</p>