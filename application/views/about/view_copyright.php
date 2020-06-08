<header title="Copyright">
	<?php if (! $logged_in): ?>
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2>Copyright</h2>

		<?php include(__DIR__ . '/../partials/register_form.php'); ?>
	<?php else: ?>
	<h3>Copyright</h3>
	<?php endif; ?>
</header>

<p>You are free to use the information and graphics as you like. I've actually stolen a large portion of the graphics
	from other sites, without asking.
	This will change in the future when the game is getting more visitors. For now, many things are happening and I
	don't want to focus on the little things.</p>

<p>If I've stolen something from you, I'm sorry. Just tell me and I will replace the item as fast as I can.</p>

<p>There isn't very much of value that you can steal from my site so go ahead. The valuable part is the code behind the
	scenes of which you cannot access.</p>

<p>I'm sure there are bugs in the game and security holes that hasn't been detected yet. It's fine if you decide to test
	this game and see how lazy I've been.
	I actually consider this helpful if you tell me afterwards. But of course it's not OK to damage the system if you
	could. This is against the law. Duh.</p>

<p>-Tony</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>