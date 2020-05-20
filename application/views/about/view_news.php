<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="News">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url()?>assets/images/design/game_start.jpg" alt="Front image">
		<h2>News</h2>
		
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
		<h3>News</h3>
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

<div id="msg"></div>

<?php if (isset($user) && $user['admin'] == 1): ?>
	<section id="news_form_section">
		<form method="post" id="news_form" class="ajaxJSON" action="<?php echo base_url('about/news_post')?>">
			<fieldset>
				<legend>Post news</legend>
				
				<label for="time">Time</label>
				<input type="text" name="time" value="<?php echo date('Y-m-d', time())?>">
				
				<label for="news_entry">The news</label>
				<textarea name="news_entry"></textarea>
				
				<input type="submit" value="Post">
			</fieldset>
		</form>
	</section>
<?php endif; ?>

<p class="center pagination"><?php echo $pages?></p>

<section id="news_entries">
	<?php if (count($news) > 0): ?>
		<?php foreach ($news as $this_news): ?>
			<section id="entry-<?php echo $this_news['id']?>">
				<time datetime="<?php echo date("Y-m-d")?>"></time>
				<h3><?php echo date("jS F, Y", $this_news['unix_time'])?></h3>
				<ul>
					<?php foreach ($this_news['entry'] as $row): ?>
						<li><?php echo htmlspecialchars($row)?></li>
					<?php endforeach; ?>
				</ul>
				
				<?php if (isset($user) && $user['admin'] == 1): ?>
					<p style="padding-left: 1em;">
						<a class="ajaxJSON" href="<?php echo base_url('about/edit_news/' . $this_news['id'])?>"><img src="<?php echo base_url()?>assets/images/icons/edit.png" width="16"></a>
						<a class="ajaxJSON" rel="Are you sure you want to delete this?" href="<?php echo base_url('about/erase_news/' . $this_news['id'])?>"><img src="<?php echo base_url('assets/images/icons/erase.png')?>" width="16"></a>
					</p>
				<?php endif; ?>	
			</section>	
		<?php endforeach; ?>
	<?php else: ?>
		<p>No news yet...</p>
	<?php endif; ?>
</section>

<p class="center"><?php echo $pages?></p>
