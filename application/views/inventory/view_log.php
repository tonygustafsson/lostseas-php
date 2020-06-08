<?php if ($user['id'] == $player['user']['id']): ?>
<header title="Inventory: Logbook">
	<h3>Inventory: Log book</h3>
</header>
<?php else: ?>
<header
	title="About <?=$player['user']['name']?>">
	<h3>About <?=$player['user']['name']?>:
		Log book</h3>
</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML"
		title="Learn more about <?=$player['user']['name']?>"
		href="inventory/player/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Player">
			<use xlink:href="#player"></use>
		</svg>
		Player
	</a>
	<a class="ajaxHTML"
		title="See <?=$player['game']['character_name']?>s ships"
		href="inventory/ships/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML"
		title="See <?=$player['game']['character_name']?>s crew members"
		href="inventory/crew/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Crew members">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
	<a class="ajaxHTML"
		title="See graphs and data about <?=$player['game']['character_name']?>s history"
		href="inventory/history/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="History">
			<use xlink:href="#clock"></use>
		</svg>
		History
	</a>
	<a class="ajaxHTML"
		title="Check out <?=$player['game']['character_name']?>s log book"
		href="inventory/log/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Log book">
			<use xlink:href="#logbook"></use>
		</svg>
		Log book
	</a>
	<?php endif; ?>
	<a class="ajaxHTML"
		title="Say something to <?=$player['user']['name']?>"
		href="inventory/messages/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Messages">
			<use xlink:href="#message"></use>
		</svg>
		Messages
	</a>
</section>

<p>
	Hold your mouse over the log entries to see the real time the event happend.
</p>

<p class="center pagination"><?=$pages?>
</p>

<div class="divider"></div>

<?php if ($player['log']): ?>
<?php $current_week = $player['log'][0]['week']; ?>
<h3>Week <?=$player['log'][0]['week']?>
</h3>

<ul>
	<?php for ($x = 0; $x < count($player['log']); $x++): ?>
	<?php $entry = $player['log'][$x]; ?>

	<?php if ($entry['week'] < $current_week): ?>
	<?php $current_week = $entry['week']; ?>
</ul>
<h3>Week <?=$entry['week']?>
</h3>
<ul>
	<?php endif; ?>

	<li
		title="Week <?=$entry['week']?>, <?=$entry['time']?>">
		<?=$game['character_name']?> <?=$entry['entry']?>
	</li>

	<?php endfor; ?>
</ul>

<?php else: ?>
<p>No log entries yet...</p>
<?php endif; ?>

<p class="center pagination"><?=$pages?>
</p>

<div class="divider"></div>