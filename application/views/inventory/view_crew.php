<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<? if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Crew">
		<h3>Inventory: Crew</h3>
	</header>
<? else: ?>
	<header title="About <?=$player['user']['name']?>">
		<h3>About <?=$player['user']['name']?>: Crew</h3>
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

<h4>Crew members</h4>

<p>You get more info about your crew members by holding your mouse over their names.</p>

<div id="msg"></div>

<? if ($this->uri->segment(4) != ""): ?>
	<? list($order, $direction) = explode("_", $this->uri->segment(4)); ?>
<? endif; ?>

<? if ($game['crew_members'] > 0): ?>

	<form id="crew_form" class="ajaxJSON" method="post" action="<?=base_url('inventory/crew_post/' . $user['id'])?>">

		<table style="padding-bottom: 30px;">
			<tr>
				<? if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
					<th><input type="checkbox" name="check_all" onchange="checkAll('crew')"></th>
				<? endif; ?>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/name_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Name</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/nationality_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Nationality</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/created_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Created</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/doubloons_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Doubloons</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/mood_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Mood</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/health_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Health</a></th>
			</tr>

			<? foreach ($player['crew'] as $man): ?>
				<? $man['gender'] = ($man['gender'] == 'M') ? 'man' : 'woman'?>
				<tr id="crew_<?=$man['id']?>">
					<? if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
						<td><input type="checkbox" id="box_<?=$man['id']?>" name="crew[]" value="<?=$man['id']?>"></td>
					<? endif; ?>
					<td title="<?=$man['description']?>"><span class="crew_info"><img src="<?echo base_url('assets/images/icons/crew_' . $man['gender'] . '.png')?>" alt="Crew member" width="16" height="17" title="<?=ucfirst($man['gender'])?>"> <?=$man['name']?></span></td>
					<td><?=ucfirst($man['nationality'])?></td>
					<td>Week <?=$man['created']?></td>
					<td><span id="crew_doubloons_<?=$man['id']?>"><?=$man['doubloons']?></span> dbl</td>
					<td><span id="crew_friendly_mood_<?=$man['id']?>"><?=ucfirst($man['friendly_mood'])?></span> (<span id="crew_mood_<?=$man['id']?>"><?=$man['mood']?></span>)</td>
					<td><span id="crew_health_<?=$man['id']?>"><?=$man['health']?></span> %</td>
					<td id="crew_info" style="display: none">
						<div style="width: 30%; float: left;">
							<img style="width: 100%;" src="<?=base_url('assets/images/icons/crew_member_' . $man['gender'] . '.png')?>" alt="Crew member">
						</div>
						<div style="padding-left: 5%; width: 65%; float: left;">
							<p><strong><?=$man['name']?></strong></p>
							<p style="font-size: 80%;"><?=$man['description']?></p>
						</div>
					</td>
				</tr>
			<? endforeach; ?>

		</table>

		<? if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
			<p style="text-align: right;">
				<select name="action[]">
					<? foreach ($actions as $current_action => $description): ?>
						<? if ((isset($player['game'][$current_action]) && $player['game'][$current_action] > 0) || $current_action == 'discard'): ?>
							<option value="<?=$current_action?>" <? echo (($action == $current_action) ? 'selected="selected"' : '') ?>><?=$description?></option>
						<? endif; ?>
					<? endforeach; ?>
				</select>

				<input type="submit" value="Do it">
			</p>
		<? endif; ?>
	
	</form>

<? else: ?>
	<p><em>You are not companied any crew members...</em></p>
<? endif; ?>