<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="Guide: Economy">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Economy</h2>
		
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
		<h3>Guide: Economy</h3>
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

<h3>Getting money</h3>

<p>The currency in this game is doubloons (dbl), for which you can buy and sell almost anything. You will mostly get money from looting ships at sea, but you
can also sell your goods, gamble for it, fight at the bar or just old plain working.</p>

<h3>Saving money</h3>

<img src="<?php echo base_url('assets/images/design/about_bank.jpg')?>" alt="Bank" align="right" style="margin-right: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">

<p>There is a banking system in this game. When you lose a battle at sea, you will lose all your doubloons, no matter how many ships you've got.
It would be impossible to achieve anything if you couldn't save it in a safe place.</p>

<p>You have a bank account that you can put your money into and out of no matter which nation you are in. If you put in 100 dbl in Panama, you can
take it out in Port Royale without any trouble.</p>

<p>It's recommended to only have cash when you are in a town, for buying and selling. Before you leave, you should put the rest in your account.
There is however a small tax of 5 %. If you put in 100 dbl, you can only get 95 dbl back.</p>

<h3>Loans</h3>

<p>You can also take a loan if the game are tough on you. You have to pay a rent of 15 % if you do so, and you cannot loan more than 11 500 dbl.
The usual reason to take a loan is when you haven't saved anything in your account and loses a fight at sea.</p>

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
