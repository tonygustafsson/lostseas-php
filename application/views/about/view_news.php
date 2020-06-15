<?php if (! $logged_in): ?>
<header class="area-header" class="area-header" title="News">
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">News</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
</header>
<?php else: ?>
<div class="container">
	<h2>News</h2>
</div>
<?php endif; ?>

<div class="container">
	<div class="button-area">
		<?php if (!$logged_in): ?>
		<a class="ajaxHTML button big-icon" title="Presentation about the game"
			href="<?=base_url('about/presentation')?>">
			<svg width="32" height="32" class="Start">
				<use xlink:href="#swords"></use>
			</svg>
			Start
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon" title="A complete guide for this game"
			href="<?=base_url('about')?>">
			<svg width="32" height="32" class="Guide">
				<use xlink:href="#logbook"></use>
			</svg>
			Guide
		</a>
		<a class="ajaxHTML button big-icon" title="What's new in here?"
			href="<?=base_url('about/news')?>">
			<svg width="32" height="32" class="News">
				<use xlink:href="#magazine"></use>
			</svg>
			News
		</a>
	</div>

	<?php if (isset($user) && $user['admin'] == 1): ?>
	<section id="news_form_section">
		<form method="POST" id="news_form" class="ajaxJSON news-form"
			action="<?=base_url('about/news_post')?>">
			<fieldset>
				<input type="hidden" value="" name="news_id" id="news_form_post_id" />
				<legend id="news_form_legend">Post news</legend>

				<label for="time">Time</label>
				<input type="text" name="time"
					value="<?=date('Y-m-d', time())?>"
					id="news_form_time">

				<label for="news_entry">The news</label>
				<textarea name="news_entry" id="news_form_entry"></textarea>

				<button type="submit">Post</button>
			</fieldset>
		</form>
	</section>
	<?php endif; ?>

	<p class="text-center pagination">
		<?=$pages?>
	</p>

	<section id="news_entries">
		<?php if (count($news) > 0): ?>
		<?php foreach ($news as $this_news): ?>
		<section
			id="entry-<?=$this_news['id']?>">
			<time
				datetime="<?=date("Y-m-d")?>"></time>
			<h3><?=date("jS F, Y", $this_news['unix_time'])?>
			</h3>
			<ul>
				<?php foreach ($this_news['entry'] as $row): ?>
				<li><?=htmlspecialchars($row)?>
				</li>
				<?php endforeach; ?>
			</ul>

			<?php if (isset($user) && $user['admin'] == 1): ?>
			<p style="padding-left: 1em;">
				<a class="ajaxJSON"
					href="<?=base_url('about/edit_news/' . $this_news['id'])?>"
					title="Edit">
					<svg width="24" height="24" alt="Edit">
						<use xlink:href="#pencil"></use>
					</svg>
				</a>
				<a class="ajaxJSON" rel="Are you sure you want to delete this?"
					href="<?=base_url('about/erase_news/' . $this_news['id'])?>"
					title="Remove">
					<svg width="24" height="24" alt="Remove">
						<use xlink:href="#broom"></use>
					</svg>
				</a>
			</p>
			<?php endif; ?>
		</section>
		<?php endforeach; ?>
		<?php else: ?>
		<p>No news yet...</p>
		<?php endif; ?>
	</section>

	<p class="text-center pagination">
		<?=$pages?>
	</p>
</div>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>