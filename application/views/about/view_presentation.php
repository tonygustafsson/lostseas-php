<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="Presentation">
	<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
	<h2>Welcome!</h2>
	
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
</header>

<div id="msg"></div>

<section class="actions">
	<?php if (! $logged_in): ?>
		<a class="ajaxHTML" title="Presentation about the game" href="<?php echo base_url('about/presentation')?>"><img src="<?php echo base_url('assets/images/icons/presentation.png')?>" alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game" href="<?php echo base_url('about/guide_supplies')?>"><img src="<?php echo base_url('assets/images/icons/guide.png')?>" alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?" href="<?php echo base_url('about/news')?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="News" width="32" height="32">News</a>
	<a class="ajaxHTML" title="Ideas for the future of the game" href="<?php echo base_url('about/ideas')?>"><img src="<?php echo base_url('assets/images/icons/about_ideas.png')?>" alt="Ideas" width="32" height="32">Ideas</a>
</section>

<h3>Presentation</h3>

<p>
	This is a pirate-influenced, web based game in beta stage. No registration is neccessary - just press Play!
</p>

<p>
	You will travel from town to town, and encounter many ships on the Caribbean Sea. Some are friendly, and some will attack you at sight. The main goal of the game is to get higher ranks. From a simple pirate, to ensign, to duke.
</p>

<p>
	There are 16 different towns to visit with a lot of different places in them to explore. You will have a crew and one or more ships. Every crew member has a name, an age, a health and a mood. You have to please your crew, or they will leave you.
</p>

<p>
	Please read the <a href="<?php echo base_url('about/guide_supplies')?>">guide</a> if you want to know more before you start playing!
</p>