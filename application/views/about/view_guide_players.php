<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="Guide: Players">
	<? if (! $logged_in): ?>
		<img class="header" src="<?echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Players</h2>
		
		<form id="register" method="post" action="<?=base_url('account/register_temp')?>">
			<fieldset>
				<legend>Start playing right now...</legend>
							
				<section id="register_left">
					<div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
						<input type="hidden" id="character_avatar" name="character_avatar" value="<?=$character['character_avatar']?>">
						<input type="hidden" id="character_gender" name="character_gender" value="<?=$character['character_gender']?>">

						<div id="avatar_selector_div" title="Avatar selector" data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>"></div>

						<img id="current_avatar_img" style="border-radius: 4px; border: 1px black solid;" src="<?=$character['character_avatar_path']?>" alt="Avatar"><br>
						<button type="button" id="change_avatar_button">Change</button>
					</div>

					<label for="character_name">Character name</label>
					<input id="character_name" type="text" name="character_name" value="<?=$character['character_name']?>">
					
					<label for="character_age">Character age</label>
					<input id="character_age" type="number" min="15" max="80" style="width: 50px;" name="character_age" value="<?=$character['character_age']?>"><br>

					<a class="ajaxJSON" href="<?=base_url('account/generate_character')?>" title="Generate random character"><img src="<?=base_url('assets/images/icons/tavern_gamble.png')?>" alt="Random" style="padding: 1em"></a><br>
				</section>
				
				<section id="register_right">
					<input type="submit" value="Play!">
				</section>
			</fieldset>
		</form>

	<? else: ?>
		<h3>Guide: Players</h3>
	<? endif; ?>
</header>

<section class="actions">
	<? if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?=base_url('about/presentation')?>"><img src="<?=base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<? endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?=base_url('about/guide_supplies')?>"><img src="<?=base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?=base_url('about/news')?>"><img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?=base_url('about/ideas')?>"><img src="<?=base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
	<a class="ajaxHTML" title="About web technologies used to create this game" href="<?=base_url('about/tech')?>"><img src="<?=base_url('assets/images/icons/about_tech.png')?>" alt="Tech" width="32" height="32">Tech</a>
</section>

<div class="divider"></div>

<section class="actions">
	<a class="ajaxHTML" title="About food, water, and other stuff" href="<?=base_url('about/guide_supplies')?>"><img src="<?=base_url('assets/images/icons/food.png')?>" alt="Supplies" width="32" height="32">Supplies</a>
	<a class="ajaxHTML" title="About ships and gun power" href="<?=base_url('about/guide_ships')?>"><img src="<?=base_url('assets/images/icons/coast.png')?>" alt="Ships" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="About crew and how to please them" href="<?=base_url('about/guide_crew')?>"><img src="<?=base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
	<a class="ajaxHTML" title="About titles, levels and ranks" href="<?=base_url('about/guide_titles')?>"><img src="<?=base_url('assets/images/icons/cityhall_governor.png')?>" alt="Titles" width="32" height="32">Titles</a>
	<a class="ajaxHTML" title="About money and banking" href="<?=base_url('about/guide_economy')?>"><img src="<?=base_url('assets/images/icons/bank.png')?>" alt="Economy" width="32" height="32">Economy</a>
	<a class="ajaxHTML" title="About travling and sea battles" href="<?=base_url('about/guide_traveling')?>"><img src="<?=base_url('assets/images/icons/travel.png')?>" alt="Travling" width="32" height="32">Traveling</a>
	<a class="ajaxHTML" title="About other players and how to interact with them" href="<?=base_url('about/guide_players')?>"><img src="<?=base_url('assets/images/icons/players.png')?>" alt="Players" width="32" height="32">Players</a>
	<a class="ajaxHTML" title="About settings and anonymity" href="<?=base_url('about/guide_settings')?>"><img src="<?=base_url('assets/images/icons/settings_character.png')?>" alt="Settings" width="32" height="32">Settings</a>
</section>

<div class="divider"></div>

<h3>Other players</h3>

<p>You can compare your own success with others, by clicking "Players" in the top menu. The information you can see about others are pretty much
the same as you can see about yourself in your inventory.</p>

<p style="text-align: center;">
	<img src="<?echo base_url()?>assets/images/design/about_players.jpg" alt="Players" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<h3>Chatting</h3>

<p>The chat can be opened by clicking "Parley" at the top menu. It will open in a new windows so you can play and chat side by side. Not a very
feature rich chat yet though...</p>

<h3>Messaging</h3>

<p>You can leave messages to each other even if you are not online by writing guestbook entries. The user will get notified by email if he or she
hasn't turned this feature of. If so, the user will still be notified the next time he or she logs in.</p>

<p style="text-align: center;">
	<img src="<?echo base_url()?>assets/images/design/about_messages.jpg" alt="Guestbook" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>