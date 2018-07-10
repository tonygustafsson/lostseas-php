<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="Tech">
	<?php if (! $logged_in): ?>
		<img class="header" src="<?php echo base_url('assets/images/design/game_start.jpg')?>" alt="Front image">
		<h2>Technologies</h2>
		
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
		<h3>Technologies</h3>
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

<h3>CodeIgniter 3.1.9</h3>
<p>
	<?php echo $this->config->item('site_name')?> is using the PHP framework <a href="http://codeigniter.com/">CodeIgniter</a> to simplify a lot of stuff that wastes unnecessary time in PHP.
	I choose CodeIgniter because it's fast, and doesn't load a lot of crap when you don't need it. The MVC approach is also very helpful in big projects.
</p>

<h3>jQuery 3</h3>
<p>
	This will probably change in the future, to react.
</p>

<p>
	I've choosen to make this game AJAX based, which means that the whole page won't reload every time you click a link, or press a button.
	Instead, just the important pieces of the page is updated. This makes things a lot faster, and let's you play music without interruption.
</p>

<h3>Wen standards</h3>
<p>
	This game <a href="http://validator.w3.org/check?uri=http%3A%2F%2Flostseas.com">validates as HTML5</a>.
	It has some nice features like pushState, new form elements and SEO friendliness that I use.
</p>

<h3>Speed</h3>
<p>
	This game has 94 points out of 100 on <a href="http://developers.google.com/speed/pagespeed/insights/?url=www.lostseas.com">Googles Page Speed</a>
	This does not mean that the page automatically is really fast, that depends on the web server, the users connection and some other factors.
	It does mean, however, that I really tried to speed things up a bit. It has to do with compression, the right HTTP headers,
	good browser cache, fewer HTTP requests and to load the right code when needed.
</p>

<p>
	Yes, I could do even more. But not very much without making it much to maintain the code and develop new things.
	It just isn't worth it to make it hard to make new things, just to make a bit of Javascript 5 kb smaller, when todays Internet connections
	let's you download megabytes per second.
</p>

<h3>Mobility</h3>
<p>
	<?php echo $this->config->item('site_name')?> can be played on a mobile device. I've not focused too much on this, but it works.
	To my help I've used responsive design. This design is temporary, and in the future I would like a totally fluid
	design with a mobile first approach.
</p>

<p>
	Anyway, if you resize the browser window you will see that the panels to the left and right gets smaller, and if you
	resize further, they will collapse into menu buttons on the top instead to save space. Kind of cool.
</p>