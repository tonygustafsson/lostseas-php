<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="Guide: Titles">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Guide: Titles</h2>
		
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
		<h3>Guide: Titles</h3>
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

<h3>Nations</h3>
<p>This game takes place at the Spanish Main, in the Caribbean Sea at the 1600th. There are four nations, battling over the towns.
English, French, Spanish and Dutch.</p>

<h3>Levels</h3>
<img src="<?php echo base_url()?>assets/images/design/about_governor.jpg" alt="Governor" align="right" style="margin: 20px 20px 10px 10px; border: 3px solid rgb(163, 162, 126);">

<p>The level system in this game is pretty simple. You belong to a nation, and for every ship you win over from that nations enemy will raise your
level by 1. And if you fight your own nations ships it will be lowered by the same amount. Winning over neutral ships doesn't change your level, but
it still meaningful to loot some gold from them.</p>

<h3>Titles</h3>

<p>Levels doesn't do anything by itself, but you will be judged by the nations governor (At the City Hall) by it. You will get promoted if you
are doing a good job. You will then get a reward, and higher titles will let you own more ships, which in turn give access to more crew members,
cannons and being able to load more goods. Some would say that the main goal of this game (if you need any) is to reach the highest title.</p>

<h3>The different titles</h3>
<table style="padding: 1em;">
	<tr>
		<th>Level</th>
		<th>Title</th>
		<th>Reward</th>
		<th>Max ships</th>
	</tr>
	
	<tr>
		<td>0-9</td>
		<td>Pirate</td>
		<td>No reward</td>
		<td>3</td>
	</tr>
	
	<tr>
		<td>10-19</td>
		<td>Ensign</td>
		<td>1000 dbl</td>
		<td>5</td>
	</tr>
	
	<tr>
		<td>20-29</td>
		<td>Captain</td>
		<td>2500 dbl</td>
		<td>6</td>
	</tr>
	
	<tr>
		<td>30-39</td>
		<td>Major</td>
		<td>4000 dbl</td>
		<td>7</td>
	</tr>
	
	<tr>
		<td>40-49</td>
		<td>Colonel</td>
		<td>6000 dbl</td>
		<td>8</td>
	</tr>
	
	<tr>
		<td>50-64</td>
		<td>Admiral</td>
		<td>8000 dbl</td>
		<td>10</td>
	</tr>
	
	<tr>
		<td>65-79</td>
		<td>Baron</td>
		<td>10 000 dbl</td>
		<td>11</td>
	</tr>
	
	<tr>
		<td>80-99</td>
		<td>Count</td>
		<td>15 000 dbl</td>
		<td>12</td>
	</tr>
	
	<tr>
		<td>100-119</td>
		<td>Marquis</td>
		<td>20 000 dbl</td>
		<td>13</td>
	</tr>
	
	<tr>
		<td>120+</td>
		<td>Duke</td>
		<td>35 000 dbl</td>
		<td>15</td>
	</tr>
	
</table>

<h3>Changing nation</h3>

<p>If you are not pleased by your nation you can actually change it. You do this by attacking the enemy of the nation you want to be a
citizen of. So if you want to be English, attack a lot of French ships! When you have won over more French ships than over English ships
you can buy yourself a citizenship. The title you receive depends on your level (which depends on how many more French ships than English ships
you have destroyed).</p>

<p>Just to make things clear: If you are a Spanish citizen and have attacked 50 French ships even though this isn't your enemy, and you have
not attacked any English ships, you will be an english Admiral at once when you buy yourself an english citizenship.</p>