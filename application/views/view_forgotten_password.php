<header title="Forgotten password">
	<img class="header" src="<?=base_url('assets/images/design/game_start.jpg')?>">
	<h2>Forgotten password</h2>
	
		<form id="register" method="post" action="<?=base_url('account/register_temp')?>">
			<fieldset>
				<legend>Start playing right now...</legend>
							
				<section id="register_left">
					<div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
						<input type="hidden" id="character_avatar" name="character_avatar" value="<?=$character['character_avatar']?>">
						<input type="hidden" id="character_gender" name="character_gender" value="<?=$character['character_gender']?>">

						<img id="current_avatar_img" style="border: 1px black solid;" src="<?=$character['character_avatar_path']?>" alt="Avatar"><br>
						<button type="button" id="js-start-avatar-selector-trigger">Change</button>
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
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Presentation about the game" href="<?=base_url('about/presentation')?>"><img src="<?=base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?=base_url('about/guide_supplies')?>"><img src="<?=base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?=base_url('about/news')?>"><img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?=base_url('about/ideas')?>"><img src="<?=base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
</section>

<p>
	Type your email address in the field below to recieve a reset link. Once you click on that link, you will
	get the change to retype your password.
</p>

<form class="ajaxJSON" style="margin: 1em;" method="post" action="<?=base_url('account/password_send_reset_link')?>">
	<fieldset>
		<legend>Reset password</legend>

		<label for="email">Email address</label>
		<input id="name" type="text" name="name">
		<input id="email" type="email" name="email">
		
		<br><input type="submit" value="Reset password">
	</fieldset>
</form>

<div
	id="js-start-avatar-selector-dialog"
	class="dialog"
	tabindex="-1"
	role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>"
	>
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>
