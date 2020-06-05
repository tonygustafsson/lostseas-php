<?php
    $in_town = array('dock', 'shop', 'tavern', 'shipyard', 'cityhall', 'market', 'bank');
    $nav_dock_display = in_array($game['place'], $in_town) ? 'block' : 'none';
    $nav_harbor_display = $game['place'] == 'harbor' && empty($game['event_ship']) ? 'block' : 'none';
    
    if (!empty($this->data['game']['event_ship'])) {
        list($nation, $type, $crew, $cannons) = explode('###', $this->data['game']['event_ship']);
    } else {
        $nation = null;
    }

    $nav_ocean_display = $game['place'] == 'ocean' && (empty($game['event_ship']) && empty($game['event_ship_won']) && empty($game['event_ocean_trade'])) ? 'block' : 'none';
    $nav_unfriendly_ship_display = !empty($game['event_ship']) && ($nation == 'pirate' || $nation == $game['enemy']) ? 'block' : 'none';
    $nav_friendly_ship_display = !empty($game['event_ship']) && $nation == $game['nationality'] ? 'block' : 'none';
    $nav_neutral_ship_display = !empty($game['event_ship']) && $nation != $game['nationality'] && $nation != 'pirate' && $nation != $game['enemy'] && $nation !== null ? 'block' : 'none';
?>

<aside id="action_panel" class="action-panel">
	<h3>Actions</h3>

	<nav id="nav_dock" style="display: <?=$nav_dock_display?>">
		<div>
			<a class="ajaxHTML" title="Visit the shop"
				href="<?=base_url('shop')?>">
				<svg alt="Shop" width="28" height="28">
					<use xlink:href="#shop"></use>
				</svg>
				Shop
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Visit the tavern"
				href="<?=base_url('tavern')?>">
				<svg alt="Tavern" width="28" height="28">
					<use xlink:href="#tavern"></use>
				</svg>
				Tavern
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Visit the city hall"
				href="<?=base_url('cityhall')?>">
				<svg alt="CityHall" width="28" height="28">
					<use xlink:href="#cityhall"></use>
				</svg>
				City Hall
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Visit the bank"
				href="<?=base_url('bank')?>">
				<svg alt="Tavern" width="28" height="28">
					<use xlink:href="#bank"></use>
				</svg>
				Bank
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Visit the shipyard"
				href="<?=base_url('shipyard')?>">
				<svg alt="Shipyard" width="28" height="28">
					<use xlink:href="#shipyard"></use>
				</svg>
				Shipyard
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Visit the market"
				href="<?=base_url('market')?>">
				<svg alt="Market" width="28" height="28">
					<use xlink:href="#market"></use>
				</svg>
				Market
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Go out to sea!"
				href="<?=base_url('harbor')?>">
				<svg alt="Harbor" width="28" height="28">
					<use xlink:href="#harbor"></use>
				</svg>
				Harbor
			</a>
		</div>
	</nav>

	<nav id="nav_harbor" style="display: <?=$nav_harbor_display?>">
		<div>
			<a class="ajaxHTML" title="Explore the ocean"
				href="<?=base_url('ocean')?>">
				<svg alt="Explore" width="28" height="28">
					<use xlink:href="#compass"></use>
				</svg>
				Explore
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Land at this town"
				href="<?=base_url('dock')?>">
				<svg alt="Harbor" width="28" height="28">
					<use xlink:href="#harbor"></use>
				</svg>
				Land
			</a>
		</div>
	</nav>

	<nav id="nav_ocean" style="display: <?=$nav_ocean_display?>">
		<div>
			<a class="ajaxHTML" title="Explore the ocean"
				href="<?=base_url('ocean')?>">
				<svg alt="Explore" width="28" height="28">
					<use xlink:href="#compass"></use>
				</svg>
				Explore
			</a>
		</div>
	</nav>

	<nav id="nav_ship_meeting_unfriendly"
		style="display: <?=$nav_unfriendly_ship_display?>">
		<div>
			<a class="ajaxHTML" title="Attack this ship!"
				href="<?=base_url('ocean/attack')?>">
				<svg alt="Attack" width="28" height="28">
					<use xlink:href="#cannon"></use>
				</svg>
				Attack
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Try to flee!"
				href="<?=base_url('ocean/flee')?>">
				<svg alt="Flee" width="28" height="28">
					<use xlink:href="#steer"></use>
				</svg>
				Flee
			</a>
		</div>
	</nav>

	<nav id="nav_ship_meeting_friendly"
		style="display: <?=$nav_friendly_ship_display?>">
		<div>
			<a class="ajaxHTML" title="Attack this ship!"
				href="<?=base_url('ocean/attack')?>">
				<svg alt="Attack" width="28" height="28">
					<use xlink:href="#cannon"></use>
				</svg>
				Attack
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Trade with these sea men"
				href="<?=base_url('ocean/trade')?>">
				<svg alt="Flee" width="28" height="28">
					<use xlink:href="#barrels"></use>
				</svg>
				Trade
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Ignore this ship"
				href="<?=base_url('ocean/ignore')?>">
				<svg alt="Flee" width="28" height="28">
					<use xlink:href="#steer"></use>
				</svg>
				Ignore
			</a>
		</div>
	</nav>

	<nav id="nav_ship_meeting_neutral"
		style="display: <?=$nav_neutral_ship_display?>">
		<div>
			<a class="ajaxHTML" title="Attack this ship!"
				href="<?=base_url('ocean/attack')?>">
				<svg alt="Attack" width="28" height="28">
					<use xlink:href="#cannon"></use>
				</svg>
				Attack
			</a>
		</div>

		<div>
			<a class="ajaxHTML" title="Ignore this ship"
				href="<?=base_url('ocean/ignore')?>">
				<svg alt="Flee" width="28" height="28">
					<use xlink:href="#steer"></use>
				</svg>
				Ignore
			</a>
		</div>
	</nav>
</aside>