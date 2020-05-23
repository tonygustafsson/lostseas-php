<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Logbook">
		<h3>Inventory: Log book</h3>
	</header>
<?php else: ?>
	<header title="About <?php echo $player['user']['name']?>">
	<h3>About <?php echo $player['user']['name']?>: Log book</h3>
	</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML" title="Learn more about <?php echo $player['user']['name']?>" href="inventory/player/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s ships" href="inventory/ships/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s crew members" href="inventory/crew/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?php echo $player['game']['character_name']?>s history" href="inventory/history/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?php echo $player['game']['character_name']?>s log book" href="inventory/log/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Say something to <?php echo $player['user']['name']?>" href="inventory/messages/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<p>
	Hold your mouse over the log entries to see the real time the event happend.
</p>

<p class="center pagination"><?php echo $pages?></p>

<div class="divider"></div>

<?php if ($player['log']): ?>
	<?php $current_week = $player['log'][0]['week']; ?>
	<h3>Week <?php echo $player['log'][0]['week']?></h3>
	
	<ul>
		<?php for ($x = 0; $x < count($player['log']); $x++): ?>
			<?php $entry = $player['log'][$x]; ?>
			
			<?php if ($entry['week'] < $current_week): ?>
				<?php $current_week = $entry['week']; ?>
				</ul>
				<h3>Week <?php echo $entry['week']?></h3>
				<ul>
			<?php endif; ?>
			
			<li title="Week <?php echo $entry['week']?>, <?php echo $entry['time']?>"><?php echo $game['character_name']?> <?php echo $entry['entry']?></li>
			
		<?php endfor; ?>
	</ul>

<?php else: ?>
	<p>No log entries yet...</p>
<?php endif; ?>

<p class="center pagination"><?php echo $pages?></p>

<div class="divider"></div>