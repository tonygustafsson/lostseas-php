<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="Ideas">
	<? if (! $logged_in): ?>
		<img class="header" src="<?echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Ideas</h2>
		
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
		<h3>Ideas</h3>
	<? endif; ?>
</header>

<div id="msg"></div>

<section class="actions">
	<? if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?=base_url('about/presentation')?>"><img src="<?=base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<? endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?=base_url('about/guide_supplies')?>"><img src="<?=base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?=base_url('about/news')?>"><img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?=base_url('about/ideas')?>"><img src="<?=base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
	<a class="ajaxHTML" title="About web technologies used to create this game" href="<?=base_url('about/tech')?>"><img src="<?=base_url('assets/images/icons/about_tech.png')?>" alt="Tech" width="32" height="32">Tech</a>
</section>

<p>
	I will put in ideas for the game and it's future. You can suggest changes at the bottom of this page.
</p>

<h3>Features</h3>

<ul>
	<li>A nice canvas map over the ocean, and a ship you steer with the arrow keys. I want a feeling of time passing by,
	and be able to sail to different waters with different characteristics.</li>
	<li>A pirate town! Harr!! With mainly pirates at the coast.</li>
	<li>Interactive fights, not just pressing "attack" and see what's happens.</li>
	<li>Trading between players when they are at the same town.</li>
	<li>Some sort of over all score, that tells you which players are best at a glance.</li>
	<li>Difference between towns. Such as images, mood, avatars, and some functional differences. Like specific items to buy and such.</li>
	<li>Missions! From avatars and governors. Maybe multiple missions at once. Maybe you have to travel to a place, get something and get back. Things like that.</li>
	<li>A new event system with it's own table, making it easier for an average developer like myself.</li>
	<li>Create avatars that can talk to you while you game. Not just gibberish, but helpful information and clues.</li>
	<li>Different images on all crew members, and skip the bad descriptions of them.</li>
	<li>A map that you can access whereever you are, not just on the seven seas.</li>
	<li>Some sort of "whats going on in the game" screen, log from all users, statistics and so on.</li>
	<li>The different ship types needs to differ more from each other. You don't gain that much from buying a more expensive ship right now.</li>
	<li>A better gaming guide, maybe an annoying parrot, with tips on what you should do next. Not just warnings at the docks.</li>
	<li>Better, more intelligent greeting phrases.</li>
	<li>WebRTC based chat (The world isn't quite ready yet). Or HTML5 sockets?</li>
	<li>A developer guide (for myself at this moment). This game is quit large by now and has it's own framework (sort of).</li>
	<li>New design, from the ground up. Mobile first, of course.</li>
	<li>Watch CodeIgniters future, do I have to change PHP framework?</li>
	<li>Replace all alerts and prompts with jQuery dialog boxes.</li>
	<li>Set some global events, like weather, and implement it for all users, create a living environment.</li>
	<li>Get notices from the chat when nick is mentioned.</li>
	<li>Move functions from the gamelib to models, helpers and config instead.</li>
</ul>

<form class="ajaxJSON" id="form_suggestion" method="post" action="<?=base_url('about/send_suggestion')?>">
	<fieldset>
		<legend>Suggest a feature</legend>
		
		<label for="your_name">Name</label>
		<input type="text" name="name" id="name">
		<input type="text" id="your_name" name="your_name" value="<?=(isset($user['name'])) ? $user['name'] : ''; ?>">
		
		<label for="email">Email address</label>
		<input type="email" id="email" name="email" value="<?=(isset($user['email'])) ? $user['email'] : ''; ?>">
		
		<label for="suggestion">Suggestion</label>
		<textarea id="suggestion" name="suggestion"></textarea>
		
		<input type="submit" value="Send">
	</fieldset>
</form>