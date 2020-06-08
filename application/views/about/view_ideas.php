<header title="Ideas">
	<?php if (! $logged_in): ?>
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2>Ideas</h2>

		<?php include(__DIR__ . '/../partials/register_form.php'); ?>

	<?php else: ?>
	<h3>Ideas</h3>
	<?php endif; ?>
</header>

<section class="action-buttons">
	<?php if (! $logged_in): ?>
	<a class="ajaxHTML" title="Presentation about the game"
		href="<?=base_url('about/presentation')?>"><img
			src="<?=base_url('assets/images/icons/presentation.png')?>"
			alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game"
		href="<?=base_url('about/guide_supplies')?>"><img
			src="<?=base_url('assets/images/icons/guide.png')?>"
			alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?"
		href="<?=base_url('about/news')?>"><img
			src="<?=base_url('assets/images/icons/about_news.png')?>"
			alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game"
		href="<?=base_url('about/ideas')?>"><img
			src="<?=base_url('assets/images/icons/about_ideas.png')?>"
			alt="Ideas" width="32" height="32">Ideas</a>
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
	<li>Difference between towns. Such as images, mood, avatars, and some functional differences. Like specific items to
		buy and such.</li>
	<li>Missions! From avatars and governors. Maybe multiple missions at once. Maybe you have to travel to a place, get
		something and get back. Things like that.</li>
	<li>A new event system with it's own table, making it easier for an average developer like myself.</li>
	<li>Create avatars that can talk to you while you game. Not just gibberish, but helpful information and clues.</li>
	<li>Different images on all crew members, and skip the bad descriptions of them.</li>
	<li>A map that you can access whereever you are, not just on the seven seas.</li>
	<li>Some sort of "whats going on in the game" screen, log from all users, statistics and so on.</li>
	<li>The different ship types needs to differ more from each other. You don't gain that much from buying a more
		expensive ship right now.</li>
	<li>A better gaming guide, maybe an annoying parrot, with tips on what you should do next. Not just warnings at the
		docks.</li>
	<li>Better, more intelligent greeting phrases.</li>
	<li>WebRTC based chat (The world isn't quite ready yet). Or HTML5 sockets?</li>
	<li>A developer guide (for myself at this moment). This game is quit large by now and has it's own framework (sort
		of).</li>
	<li>New design, from the ground up. Mobile first, of course.</li>
	<li>Watch CodeIgniters future, do I have to change PHP framework?</li>
	<li>Replace all alerts and prompts with jQuery dialog boxes.</li>
	<li>Set some global events, like weather, and implement it for all users, create a living environment.</li>
	<li>Get notices from the chat when nick is mentioned.</li>
	<li>Move functions from the gamelib to models, helpers and config instead.</li>
</ul>

<form class="ajaxJSON" id="form_suggestion" method="post"
	action="<?=base_url('about/send_suggestion')?>">
	<fieldset>
		<legend>Suggest a feature</legend>

		<label for="your_name">Name</label>
		<input type="text" name="name" id="name">
		<input type="text" id="your_name" name="your_name"
			value="<?=(isset($user['name'])) ? $user['name'] : ''; ?>">

		<label for="email">Email address</label>
		<input type="email" id="email" name="email"
			value="<?=(isset($user['email'])) ? $user['email'] : ''; ?>">

		<label for="suggestion">Suggestion</label>
		<textarea id="suggestion" name="suggestion"></textarea>

		<input type="submit" value="Send">
	</fieldset>
</form>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>