<div class="container">
	<h2>Caribbean Sea</h2>

	<?php if (isset($game['won'])): ?>
	<p><?=$game['won']?>
	</p>
	<?php endif; ?>

	<?php if (isset($game['lost'])): ?>
	<p><?=$game['lost']?>
	</p>
	<?php endif; ?>

	<?php if (isset($game['good'])): ?>
	<ul class="ocean-event-results">
		<?php foreach ($game['good'] as $image => $msg): ?>
		<li class="positive">
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#<?=$svg_id?>"></use>
			</svg>
			<?=$msg?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if (isset($game['bad'])): ?>
	<ul>
		<?php foreach ($game['bad'] as $image => $msg): ?>
		<li class="negative">
			<svg width="32" height="32" alt="<?=$svg_id?>">
				<use xlink:href="#<?=$svg_id?>"></use>
			</svg>
			<?=$msg?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if (! isset($game['good']) && ! isset($game['bad'])): ?>
	<p>
		<?=$game['greeting']?>
	</p>
	<?php endif; ?>

	<p>
		Click on the town on the map to visit it. Hover over the town to get the name and country.
	</p>

	<p class="mobile-only">
		On mobile devices you swipe the map back and forth to be able to see the whole of the map.
	</p>

	<p>
		<strong>English:</strong>
		<a href="<?=base_url('harbor/charles_towne')?>"
			class="ajaxHTML js-town-focus" data-focus-town="charles-towne">Charles Towne</a>,
		<a href="<?=base_url('harbor/barbados')?>"
			class="ajaxHTML js-town-focus" data-focus-town="barbados">Barbados</a>,
		<a href="<?=base_url('harbor/port_royale')?>"
			class="ajaxHTML js-town-focus" data-focus-town="port-royale">Port Royale</a>,
		<a href="<?=base_url('harbor/belize')?>"
			class="ajaxHTML js-town-focus" data-focus-town="belize">Belize</a>

		<br />

		<strong>French:</strong>
		<a href="<?=base_url('harbor/tortuga')?>"
			class="ajaxHTML js-town-focus" data-focus-town="tortuga">Tortuga</a>,
		<a href="<?=base_url('harbor/leogane')?>"
			class="ajaxHTML js-town-focus" data-focus-town="leogane">Leogane</a>,
		<a href="<?=base_url('harbor/martinique')?>"
			class="ajaxHTML js-town-focus" data-focus-town="martinique">Martinique</a>,
		<a href="<?=base_url('harbor/biloxi')?>"
			class="ajaxHTML js-town-focus" data-focus-town="biloxi">Biloxi</a>

		<br />

		<strong>Spanish:</strong>
		<a href="<?=base_url('harbor/panama')?>"
			class="ajaxHTML js-town-focus" data-focus-town="panama">Panama</a>,
		<a href="<?=base_url('harbor/havana')?>"
			class="ajaxHTML js-town-focus" data-focus-town="havana">Havana</a>,
		<a href="<?=base_url('harbor/villa_hermosa')?>"
			class="ajaxHTML js-town-focus" data-focus-town="villa-hermosa">Villa Hermosa</a>,
		<a href="<?=base_url('harbor/san_juan')?>"
			class="ajaxHTML js-town-focus" data-focus-town="san-juan">San Juan</a>

		<br />

		<strong>Dutch:</strong>
		<a href="<?=base_url('harbor/bonaire')?>"
			class="ajaxHTML js-town-focus" data-focus-town="bonaire">Bonaire</a>,
		<a href="<?=base_url('harbor/curacao')?>"
			class="ajaxHTML js-town-focus" data-focus-town="curacao">Curacao</a>,
		<a href="<?=base_url('harbor/st_martin')?>"
			class="ajaxHTML js-town-focus" data-focus-town="st-martin">St. Martin</a>,
		<a href="<?=base_url('harbor/st_eustatius')?>"
			class="ajaxHTML js-town-focus" data-focus-town="st-eustatius">St. Eustatius</a>
	</p>

	<?php include(__DIR__. '/ocean_map.php'); ?>
</div>