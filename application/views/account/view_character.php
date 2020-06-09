﻿<header class="area-header" class="area-header" title="Character settings">
	<h3>Character Settings</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation"
		href="<?=base_url('account/settings_account')?>">
		<svg width="32" height="32" class="Account">
			<use xlink:href="#player"></use>
		</svg>
		Account
	</a>
	<a class="ajaxHTML" title="Change your email/login adress"
		href="<?=base_url('account/settings_email')?>">
		<svg width="32" height="32" class="Email">
			<use xlink:href="#message"></use>
		</svg>
		Email
	</a>
	<a class="ajaxHTML" title="Change your character name, age and such"
		href="<?=base_url('account/settings_character')?>">
		<svg width="32" height="32" class="Character">
			<use xlink:href="#crew-man"></use>
		</svg>
		Character
	</a>
	<a class="ajaxHTML" title="Change your password for login"
		href="<?=base_url('account/settings_password')?>">
		<svg width="32" height="32" class="Password">
			<use xlink:href="#key"></use>
		</svg>
		Password
	</a>
	<a class="ajaxHTML" title="Unregister from this game"
		href="<?=base_url('account/unregister')?>">
		<svg width="32" height="32" class="Unregister">
			<use xlink:href="#trashcan"></use>
		</svg>
		Unregister
	</a>
</section>

<form id="settings" class="ajaxJSON" method="post"
	action="<?=base_url('account/settings_character_post')?>">
	<fieldset>
		<legend>Your character</legend>

		<div style="float: left; padding: 0.5em 0.5em 0.5em 1em">
			<input type="hidden" id="character_avatar" name="character_avatar"
				value="<?=$game['character_gender_long'] . '###' . $game['character_avatar']?>">
			<input type="hidden" id="character_gender" name="character_gender"
				value="<?=$game['character_gender']?>">

			<img id="current_avatar_img" style="border: 1px black solid;"
				src="<?=$game['character_avatar_path']?>"
				alt="Avatar"><br>
			<button type="button" id="js-start-avatar-selector-trigger">Change</button>
		</div>

		<div style="float: left;">
			<label for="character_name">Name</label>
			<input id="character_name" type="text" name="character_name"
				value="<?=$game['character_name']?>">
			<a class="ajaxJSON"
				href="<?=base_url('account/generate_character')?>"
				title="Generate random character">
				<svg width="24" height="24" alt="Randomize">
					<use xlink:href="#dices"></use>
				</svg>
			</a>
			<br />

			<label for="character_age">Age</label>
			<input id="character_age" type="number" name="character_age" placeholder="Character age"
				value="<?=$game['character_age']?>"><br>

			<label for="character_description">Description</label>
			<textarea
				name="character_description"><?=$game['character_description']?></textarea>

			<label for="reset_game" title="You will get 4 crew members, 1 ship and 300 dbl">Reset the game</label>
			<input type="checkbox" name="reset_game"
				onchange="alert('Warning! Your character will be replaced by a new one. You will lose all your possessions and start of again with 1 ship, 4 crew members. 2 cannons and 300 dbl.');">

			<input type="submit" value="Save" />
		</div>
	</fieldset>
</form>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/' . $game['character_gender_long'])?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>