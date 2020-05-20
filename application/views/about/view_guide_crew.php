<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="Guide: Crew">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Crew</h2>
		
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
		<h3>Guide: Crew</h3>
	<?php endif; ?>
</header>

<section class="actions">
	<?php if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?php echo base_url('about/presentation')?>"><img src="<?php echo base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?php echo base_url('about/guide_supplies')?>"><img src="<?php echo base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?php echo base_url('about/news')?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?php echo base_url('about/ideas')?>"><img src="<?php echo base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
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

<h3>Purpose of crew members</h3>

<p>The only real reason to have crew members is so that they can fight battles with you. To fire a cannon, you'll need two
crew members.</p>

<p>They demands things in return for their services. They become less happy when they do boring stuff, like working, losing battles and
traveling the great Caribbean Sea. When they are angry they will refuse to work / fight for you.</p>

<p>In order to fix this you have to please them, with food and drinks. You can visit the tavern and buy them some wine perhaps, or
give them rum from your goods if you have any.</p>

<p>You are also responsible for their health. If they lose to much health they will die in battle. You can give them medicine after battles,
or visit the towns healer when you are in land again.</p>

<h3>Getting more crew members</h3>

<p>When you win battles at sea some of their crew will offer to join you. You can then choose how many of them you want to accept.
The other method is to visit the tavern and speak to the sailors there, they often want to offer their services for free.
You could also visit the slave market, but it's expansive!</p>

<h3>Get to know them</h3>

<p>If you check your inventory you will get unnecessary amounts of information about your crew. All of them are separate beings, with their own
name and description. You can also see for how long they have been with you, how much money they have gained of being your crew.</p>

<p style="text-align: center;">
	<img src="<?php echo base_url('assets/images/design/about_crew.jpg')?>" alt="Crew" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>