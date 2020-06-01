<header title="The Ocean">
	<h2>Caribbean Sea</h2>
	<img src="<?php echo base_url('assets/images/places/ocean_' . rand(1, 7) . '.jpg')?>" class="header">
</header>

<?php if (isset($game['won'])): ?>
	<p><?php echo $game['won']?></p>
<?php endif; ?>

<?php if (isset($game['lost'])): ?>
	<p><?php echo $game['lost']?></p>
<?php endif; ?>

<?php if (isset($game['good'])): ?>
	<ul>
	<?php foreach ($game['good'] as $image => $msg): ?>
		<li class="attack_good" style="list-style-image: url('<?php echo base_url('assets/images/icons/' . $image . '.png')?>');"><?php echo $msg?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (isset($game['bad'])): ?>
	<ul>
	<?php foreach ($game['bad'] as $image => $msg): ?>
		<li class="attack_bad" style="list-style-image: url('<?php echo base_url('assets/images/icons/' . $image . '.png')?>');"><?php echo $msg?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>

<?php if (! isset($game['good']) && ! isset($game['bad'])): ?>
	<p><?php echo $game['greeting']?></p>
<?php endif; ?>

<p class="center">
	<img src="<?php echo base_url('assets/images/spanish_main.jpg')?>" usemap="#image_map" width="500" height="256" alt="The spanish main">
</p>

<map id="image_map" class="ocean-map" name="image_map">
	<area class="ajaxHTML" shape="rect" coords="198,4,215,21" href="<?php echo base_url('harbor/charles_towne')?>" alt="Charles Towne" rel="england">
	<area class="ajaxHTML" shape="rect" coords="96,31,113,48" href="<?php echo base_url('harbor/biloxi')?>" alt="Biloxi" rel="france">
	<area class="ajaxHTML" shape="rect" coords="167,91,184,108" href="<?php echo base_url('harbor/havana')?>" alt="Havana" rel="spain">
	<area class="ajaxHTML" shape="rect" coords="59,131,76,148" href="<?php echo base_url('harbor/villa_hermosa')?>" alt="Villa Hermosa" rel="spain">
	<area class="ajaxHTML" shape="rect" coords="100,134,117,151" href="<?php echo base_url('harbor/belize')?>" alt="Belize" rel="england">
	<area class="ajaxHTML" shape="rect" coords="222,132,239,149" href="<?php echo base_url('harbor/port_royale')?>" alt="Port Royale" rel="england">
	<area class="ajaxHTML" shape="rect" coords="278,118,295,135" href="<?php echo base_url('harbor/tortuga')?>" alt="Tortuga" rel="france">
	<area class="ajaxHTML" shape="rect" coords="258,129,275,146" href="<?php echo base_url('harbor/leogane')?>" alt="Leogane" rel="france">
	<area class="ajaxHTML" shape="rect" coords="336,130,353,147" href="<?php echo base_url('harbor/san_juan')?>" alt="San Juan" rel="spain">
	<area class="ajaxHTML" shape="rect" coords="382,136,399,153" href="<?php echo base_url('harbor/st._martin')?>" alt="St. Martin" rel="holland">
	<area class="ajaxHTML" shape="rect" coords="384,156,401,173" href="<?php echo base_url('harbor/st._eustatius')?>" alt="St. Eustatius" rel="holland">
	<area class="ajaxHTML" shape="rect" coords="388,170,405,187" href="<?php echo base_url('harbor/martinique')?>" alt="Martinique" rel="france">
	<area class="ajaxHTML" shape="rect" coords="402,180,419,197" href="<?php echo base_url('harbor/barbados')?>" alt="Barbados" rel="england">
	<area class="ajaxHTML" shape="rect" coords="188,222,205,239" href="<?php echo base_url('harbor/panama')?>" alt="Panama" rel="spain">
	<area class="ajaxHTML" shape="rect" coords="295,182,312,199" href="<?php echo base_url('harbor/curacao')?>" alt="Curacao" rel="holland">
	<area class="ajaxHTML" shape="rect" coords="314,185,331,202" href="<?php echo base_url('harbor/bonaire')?>" alt="Bonaire" rel="holland">
</map>