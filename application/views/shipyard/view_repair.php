<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shipyard_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Buy ships and equipments"
			href="<?=base_url('shipyard')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#icon-ship"></use>
			</svg>
			Buy
		</a>
		<a class="ajaxHTML button big-icon" title="Sell ships and equipments"
			href="<?=base_url('shipyard/sell')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#icon-ship"></use>
			</svg>
			Sell
		</a>
		<a class="ajaxHTML button big-icon" title="Repair damaged ships"
			href="<?=base_url('shipyard/repair')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#icon-wrench"></use>
			</svg>
			Repair
		</a>
	</div>

	<p>
		You can repair your ships here. You will only see your damaged ships.
	</p>

	<?php if ($game['ship_health_lowest'] < 100): ?>
	<p class="text-center">
		<a href="<?=base_url('shipyard/repair_all')?>"
			class="ajaxJSON button primary" data-prompt-heading="Repair all ships?"
			data-prompt-text="This will restore all ships health too 100%. It will cost you <?=$viewdata['repair_all_cost']?> dbl.">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#icon-wrench"></use>
			</svg>
			Repair all ships (<?=$viewdata['repair_all_cost']?> dbl)
		</a>
	</p>

	<div class="table-responsive">
		<table>
			<tr>
				<th width="80"></th>
				<th>Type</th>
				<th>Name</th>
				<th>Health</th>
				<th>Repair cost</th>
				<th></th>
			</tr>

			<?php foreach ($ship as $this_ship): ?>
			<?php if ($this_ship['health'] < 100): ?>
			<tr id="ship_<?=$this_ship['id']?>">
				<td>
					<img width="64" height="64"
						src="<?=base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>">
				</td>
				<td>
					<?=ucfirst($this_ship['type'])?>
				</td>
				<td>
					<?=$this_ship['name']?>
				</td>
				<td>
					<?=$this_ship['health']?>%
				</td>
				<td>
					<?=(100 - $this_ship['health']) * $viewdata['prices']['ship_repair']['buy']?>
					dbl
				</td>
				<td class="text-center">
					<a class="ajaxJSON button small"
						data-prompt-heading="Repair this <?=$this_ship['type']?>?"
						data-prompt-text="The ship health will be restored to 100%. It will cost you <?php echo(100 - $this_ship['health']) * $viewdata['prices']['ship_repair']['buy']?> dbl."
						title="Repair this <?=$this_ship['type']?>. Damaged by <?php echo(100 - $this_ship['health'])?> %"
						href="<?=base_url('shipyard/repair_ship/' . $this_ship['id'])?>">
						Repair
					</a>
				</td>
			</tr>
			<?php endif; ?>
			<?php endforeach; ?>
		</table>
	</div>

	<?php else: ?>
	<div class="info">
		<p><em>Your ships seems to be in perfect health.</em></p>
	</div>
	<?php endif; ?>
</div>