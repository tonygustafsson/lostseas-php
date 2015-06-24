<? if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Logbook">
		<h3>Inventory: Log book</h3>
	</header>
<? else: ?>
	<header title="About <?=$player['user']['name']?>">
	<h3>About <?=$player['user']['name']?>: Log book</h3>
	</header>
<? endif; ?>

<section class="actions">
	<a class="ajaxHTML" title="Learn more about <?=$player['user']['name']?>" href="inventory/player/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s ships" href="inventory/ships/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s crew members" href="inventory/crew/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<? if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?=$player['game']['character_name']?>s history" href="inventory/history/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?=$player['game']['character_name']?>s log book" href="inventory/log/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<? endif; ?>
	<a class="ajaxHTML" title="Say something to <?=$player['user']['name']?>" href="inventory/messages/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<p>
	Hold your mouse over the log entries to see the real time the event happend.
</p>

<p class="center"><?=$pages?></p>

<div class="divider"></div>

<? if ($player['log']): ?>
	<? $current_week = $player['log'][0]['week']; ?>
	<h3>Week <?=$player['log'][0]['week']?></h3>
	
	<ul>
		<? for ($x = 0; $x < count($player['log']); $x++): ?>
			<? $entry = $player['log'][$x]; ?>
			
			<? if ($entry['week'] < $current_week): ?>
				<? $current_week = $entry['week']; ?>
				</ul>
				<h3>Week <?=$entry['week']?></h3>
				<ul>
			<? endif; ?>
			
			<li title="Week <?=$entry['week']?>, <?=$entry['time']?>"><?=$game['character_name']?> <?=$entry['entry']?></li>
			
		<? endfor; ?>
	</ul>

<? else: ?>
	<p>No log entries yet...</p>
<? endif; ?>

<p class="center"><?=$pages?></p>

<div class="divider"></div>