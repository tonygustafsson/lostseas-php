<div class="container">
	<?php if ($user['id'] == $player['user']['id']): ?>
	<h3>Inventory: Crew</h3>
	<?php else: ?>
	<h3>
		<?=$player['game']['character_name']?>:
		Crew
	</h3>
	<?php endif; ?>

	<div class="button-area">
		<a class="ajaxHTML button big-icon"
			title="Learn more about <?=$player['game']['character_name']?>"
			href="<?=base_url('inventory/player/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Player">
				<use xlink:href="#icon-player"></use>
			</svg>
			Player
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s ships"
			href="<?=base_url('inventory/ships/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Ships">
				<use xlink:href="#icon-ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s crew members"
			href="<?=base_url('inventory/crew/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Crew members">
				<use xlink:href="#icon-crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon"
			title="See graphs and data about <?=$player['game']['character_name']?>s history"
			href="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="History">
				<use xlink:href="#icon-clock"></use>
			</svg>
			History
		</a>
		<a class="ajaxHTML button big-icon"
			title="Check out <?=$player['game']['character_name']?>s log book"
			href="<?=base_url('inventory/log/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Log book">
				<use xlink:href="#icon-logbook"></use>
			</svg>
			Log book
		</a>
	</div>

	<h4>Crew members</h4>

	<p>You get more info about your crew members by holding your mouse over their names.</p>

	<?php if ($this->uri->segment(4) != ""): ?>
	<?php list($order, $direction) = explode("_", $this->uri->segment(4)); ?>
	<?php endif; ?>

	<?php if ($game['crew_members'] > 0): ?>

	<form id="crew_form" class="ajaxJSON" method="post"
		action="<?=base_url('inventory/crew_post/' . $user['id'])?>">

		<div class="table-responsive">
			<table>
				<tr>
					<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
					<th class="text-center"><input class="js-inventory-check-all" data-select="crew" type="checkbox"
							name="check_all" /></th>
					<?php endif; ?>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/name_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Name</a>
					</th>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/nationality_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Nationality</a>
					</th>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/created_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Created</a>
					</th>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/doubloons_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Doubloons</a>
					</th>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/mood_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Mood</a>
					</th>
					<th><a class="ajaxHTML"
							href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/health_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Health</a>
					</th>
				</tr>

				<?php foreach ($player['crew'] as $man): ?>
				<?php $man['gender'] = ($man['gender'] == 'M') ? 'man' : 'woman'?>
				<tr id="crew_<?=$man['id']?>">
					<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
					<td class="text-center"><input type="checkbox"
							id="crew-checkbox-<?=$man['id']?>"
							name="crew[]"
							value="<?=$man['id']?>">
					</td>
					<?php endif; ?>
					<td>
						<span class="tooltip-multiline tooltip-bottom-left"
							data-tooltip="<?=$man['description']?>">
							<svg width="24" height="24" class="Game">
								<use
									xlink:href="#icon-crew-<?=$man['gender']?>">
								</use>
							</svg>
							<?=$man['name']?>
						</span>
					</td>
					<td><?=ucfirst($man['nationality'])?>
					</td>
					<td>Week <?=$man['created']?>
					</td>
					<td><span
							id="crew_doubloons_<?=$man['id']?>"><?=$man['doubloons']?></span>
						dbl
					</td>
					<td><span
							id="crew_friendly_mood_<?=$man['id']?>"><?=ucfirst($man['friendly_mood'])?></span>
						(<span
							id="crew_mood_<?=$man['id']?>"><?=$man['mood']?></span>)
					</td>
					<td><span
							id="crew_health_<?=$man['id']?>"><?=$man['health']?></span> %
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>

		<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
		<div class="row row-justify-right">
			<select name="action[]" class="w-m-100">
				<?php foreach ($actions as $current_action => $description): ?>
				<?php if ((isset($player['game'][$current_action]) && $player['game'][$current_action] > 0) || $current_action == 'discard'): ?>
				<option value="<?=$current_action?>" <?php echo(($action == $current_action) ? 'selected="selected"' : '') ?>><?=$description?>
				</option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>

			<button type="submit" class="ml-m-0 mt-m-1 ml-1">Do it</button>
		</div>
		<?php endif; ?>
	</form>
	<?php else: ?>
	<p><em>You are not companied any crew members...</em></p>
	<?php endif; ?>
</div>