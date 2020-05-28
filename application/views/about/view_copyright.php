<header title="Copyright">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Copyright</h2>
		
	<form id="register" method="post" action="<?php echo base_url('account/register_temp')?>">
		<fieldset>
			<legend>Start playing right now...</legend>
						
			<section id="register_left">
				<div style="float: left; padding: 0.5em 0.8em 0.5em 1em">
					<input type="hidden" id="character_avatar" name="character_avatar" value="<?php echo $character['character_avatar']?>">
					<input type="hidden" id="character_gender" name="character_gender" value="<?php echo $character['character_gender']?>">

					<img id="current_avatar_img" style=" border: 1px black solid;" src="<?php echo $character['character_avatar_path']?>" alt="Avatar"><br>
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
		<h3>Copyright</h3>
	<?php endif; ?>
</header>

<p>You are free to use the information and graphics as you like. I've actually stolen a large portion of the graphics from other sites, without asking.
This will change in the future when the game is getting more visitors. For now, many things are happening and I don't want to focus on the little things.</p>

<p>If I've stolen something from you, I'm sorry. Just tell me and I will replace the item as fast as I can.</p>

<p>There isn't very much of value that you can steal from my site so go ahead. The valuable part is the code behind the scenes of which you cannot access.</p>

<p>I'm sure there are bugs in the game and security holes that hasn't been detected yet. It's fine if you decide to test this game and see how lazy I've been.
I actually consider this helpful if you tell me afterwards. But of course it's not OK to damage the system if you could. This is against the law. Duh.</p>

<p>-Tony</p>

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
