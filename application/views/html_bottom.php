		</article>
		
		<?php if (isset($user)): ?>
			<?php /* For logged in users! */ ?>

			<aside id="inventory_panel" class="inventory">
				<h3>Inventory</h3>
				
				<?php if (! isset($no_menu)): ?>
					<div class="inventory_user">
						<a class="ajaxHTML" href="inventory/player/<?php echo $user['id']?>#character">
							<div style="height: 100%; width: 40px">
								<img id="inventory_character_avatar" src="<?php echo $game['character_avatar_thumb_path']?>" alt="Character avatar" width="120" height="120">
							</div>
							<div style="width: 100%;">
								<span id="inventory_character_name"><?php echo $game['character_name']?></span>, <span id="inventory_title"><?php echo $game['title']?></span> from <span id="inventory_nationality"><?php echo ucwords($game['nationality'])?></span>
							</div>
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($user['new_messages'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="You have new messages!" href="inventory/messages/<?php echo $user['id']?>">
							<img src="<?php echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="24" height="24">
							<span id="inventory_new_messages"><?php echo $user['new_messages']?></span> <?php echo ($user['new_messages'] > 1) ? 'messages' : 'message'; ?>
						</a>
					</div>
					
					<?php if ($game['crew_health_lowest'] <= 25) {
    $crew_health_symbol = 'crew_health_25';
} ?>
					<?php if ($game['crew_health_lowest'] > 25 && $game['crew_health_lowest'] <= 50) {
    $crew_health_symbol = 'crew_health_50';
} ?>
					<?php if ($game['crew_health_lowest'] > 50 && $game['crew_health_lowest'] <= 75) {
    $crew_health_symbol = 'crew_health_75';
} ?>
					<?php if ($game['crew_health_lowest'] > 75) {
    $crew_health_symbol = 'crew_health_100';
} ?>
				
					<?php if ($game['ship_health_lowest'] <= 25) {
    $ship_health_symbol = 'ship_health_25';
} ?>
					<?php if ($game['ship_health_lowest'] > 25 && $game['ship_health_lowest'] <= 50) {
    $ship_health_symbol = 'ship_health_50';
} ?>
					<?php if ($game['ship_health_lowest'] > 50 && $game['ship_health_lowest'] <= 75) {
    $ship_health_symbol = 'ship_health_75';
} ?>
					<?php if ($game['ship_health_lowest'] > 75) {
    $ship_health_symbol = 'ship_health_100';
} ?>
					
					<!-- Section: Game status -->
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_crew_health_link" title="You have <?php echo $game['crew_members']?> crew members with the health <?php echo $game['crew_health_lowest']?>%" href="inventory/crew/<?php echo $user['id']?>">
							<img id="inventory_crew_health_img" src="<?php echo base_url('assets/images/icons/' . $crew_health_symbol . '.png')?>" alt="Crew" width="24" height="24">
							<span id="inventory_crew"><?php echo $game['crew_members']?></span> men
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['crew_members'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" id="inventory_crew_mood_link" title="Your crew is <?php echo $game['crew_lowest_friendly_mood']?> (Mood <?php echo $game['crew_lowest_mood']?>)" href="inventory/crew/<?php echo $user['id']?>">
							<img id="inventory_crew_mood_img" src="<?php echo base_url('assets/images/icons/smiley_' . $game['crew_lowest_friendly_mood'] . '.png')?>" alt="Mood" width="24" height="24">
							<span id="inventory_crew_mood"><?php echo $game['crew_lowest_friendly_mood']?></span>
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Doubloons that you can use immediately" href="inventory/player/<?php echo $user['id']?>#capital">
							<img src="<?php echo base_url('assets/images/icons/bank.png')?>" alt="Money" width="24" height="24">
							<span id="inventory_doubloons"><?php echo $game['doubloons']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['bank_account'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Doubloons in your bank account" href="inventory/player/<?php echo $user['id']?>#capital">
							<img src="<?php echo base_url('assets/images/icons/money_bank.png')?>" alt="Account" width="24" height="24">
							<span id="inventory_bank_account"><?php echo $game['bank_account']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['bank_loan'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your bank loan amount" href="inventory/player/<?php echo $user['id']?>#capital">
							<img src="<?php echo base_url('assets/images/icons/money_bank_loan.png')?>" alt="Bank loan" width="24" height="24">
							<span id="inventory_bank_loan"><?php echo $game['bank_loan']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Amount of weeks that has passed, see log book" href="inventory/log/<?php echo $user['id']?>">
							<img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="24" height="24">
							week <span id="inventory_week"><?php echo $game['week']?></span>
						</a>
					</div>
					
					<!-- Section: Ship status -->
					<div style="padding-top: 1em; width: 100%;"></div>					
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_ships_health_link" title="You own <?php echo $game['ships']?> ships with the health <?php echo $game['ship_health_lowest']?>%" href="inventory/ships/<?php echo $user['id']?>">
							<img id="inventory_ships_health_img" src="<?php echo base_url('assets/images/icons/' . $ship_health_symbol . '.png')?>" alt="Ships" width="24" height="24">
							<span id="inventory_ships"><?php echo $game['ships']?></span> <?php echo ($game['ships'] > 1) ? 'ships' : 'ship'; ?>
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_cannons_link" title="You own <?php echo $game['cannons']?> cannons, <?php echo $game['manned_cannons']?> are manned" href="inventory/ships/<?php echo $user['id']?>">
							<img src="<?php echo base_url('assets/images/icons/shipyard_fixings.png')?>" alt="Cannons" width="24" height="24">
							<span id="inventory_manned_cannons"><?php echo $game['manned_cannons']?></span>/<span id="inventory_cannons"><?php echo $game['cannons']?></span> cannons
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['rafts'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your life boats, used in shipwreck" href="inventory/ships/<?php echo $user['id']?>">
							<img src="<?php echo base_url('assets/images/icons/raft.png')?>" alt="Raft" width="24" height="24">
							<span id="inventory_rafts"><?php echo $game['rafts']?></span> <?php echo ($game['rafts'] > 1) ? 'rafts' : 'raft'; ?>
						</a>
					</div>
					
					<!-- Section: Stock status -->
					<div style="padding-top: 1em; width: 100%;"></div>	
					
					<div class="inventory_item" style="display: <?php echo ($game['prisoners'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your prisoners, can be left in City Hall for a ransom" href="inventory/ships/<?php echo $user['id']?>">
							<img src="<?php echo base_url('assets/images/icons/cityhall_prisoners.png')?>" alt="Prisoners" width="24" height="24">
							<span id="inventory_prisoners"><?php echo $game['prisoners']?></span> prisoners
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Your food, used by crew members for sea traveling" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="24" height="24">
							<span id="inventory_food"><?php echo $game['food']?></span> food
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Your water, used by crew members for sea traveling" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/water.png')?>" alt="Water" width="24" height="24">
							<span id="inventory_water"><?php echo $game['water']?></span> water
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['porcelain'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your porcelain, used as barter goods" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/porcelain.png')?>" alt="Porcelain" width="24" height="24">
							<span id="inventory_porcelain"><?php echo $game['porcelain']?></span> porcelain
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['spices'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your spices, used as barter goods" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/spices.png')?>" alt="Spices" width="24" height="24">
							<span id="inventory_spices"><?php echo $game['spices']?></span> spices
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['silk'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your silk, used as barter goods" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/silk.png')?>" alt="Silk" width="24" height="24">
							<span id="inventory_silk"><?php echo $game['silk']?></span> silk
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['medicine'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your medicine, can heal crew members" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/medicine.png')?>" alt="Medicine" width="24" height="24">
							<span id="inventory_medicine"><?php echo $game['medicine']?></span> medicine
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['tobacco'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your tobacco, used as barter goods and can raise crew members mood" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/tobacco.png')?>" alt="Tobacco" width="24" height="24">
							<span id="inventory_tobacco"><?php echo $game['tobacco']?></span> tobacco
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?php echo ($game['rum'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your rum, used as barter goods and can raise crew members mood" href="inventory/player/<?php echo $user['id']?>#stock">
							<img src="<?php echo base_url('assets/images/icons/rum.png')?>" alt="Rum" width="24" height="24">
							<span id="inventory_rum"><?php echo $game['rum']?></span> rum
						</a>
					</div>
				<?php endif; ?>
			</aside>

		<?php else: ?>
			<?php /* For logged out users! */ ?>
			<aside id="inventory_panel" class="action-panel">
				<form method="post" action="<?php echo base_url('account/login')?>" style="width: 100%; margin: 0; padding: 0;">
					<fieldset>
						<legend>Log in</legend>
						
						<?php if ($this->session->userdata('email') || $this->session->userdata('password')): ?>
								<?php $this->session->unset_userdata('email') ?>
								<?php $this->session->unset_userdata('password') ?>
								<p style="margin: 0.2em 1em; background: #d96868; padding: 0.3em;">Your login was denied...</p>
						<?php endif; ?>
						
						<?php if (isset($user['success'])): ?>
								<div class="success"><p>You are now registered with the username: <?php echo $user['success']?>! Please log in.</p></div>
						<?php endif; ?>
						
						<label for="login_email">Email</label>
						<input type="text" id="login_email" name="login_email" autofocus style="width: 100%">
						
						<label for="login_password">Password</label>
						<input type="password" id="login_password" name="login_password" style="width: 100%">
						
						<p style="font-size: 12px; margin: 0 1em;"><a style="color: #000" class="ajaxHTML" href="<?php echo base_url('account/password_forgotten')?>">Have you forgotten your password?</a></p>
						
						<input class="small" type="submit" value="Log in" style="margin-top: 1em;">
					</fieldset>
				</form>
				
				<p>
					<a href="https://www.facebook.com/lostseas" title="Visit us on Facebook"><img src="<?php echo base_url('assets/images/design/facebook.png')?>" alt="Visit us on facebook"></a>
				</p>
			</aside>
			
			<aside id="log_panel" class="inventory">
				<h3>What's going on?</h3>
				
				<?php if (isset($log_entries)): ?>
					<?php unset($log_entries['num_rows']); ?>
					
					<?php foreach ($log_entries as $entry): ?>
						<p>
							<img style="float: left; margin: 0.3em 0.5em 0.5em 0;" src="<?php echo base_url('assets/images/avatars/' . (($entry['character_gender'] == 'M') ? 'male' : 'female') . '_thumb/avatar_' . $entry['character_avatar'] . '.jpg')?>" alt="Avatar of <?php echo $entry['character_name']?>" width="40" height="40">
							<time style="font-weight: bold"><?php echo $entry['time']?></time><br>
							<?php echo $entry['character_name']?> <?php echo $entry['entry']?>
						</p>
					<?php endforeach; ?>
				<?php endif; ?>
			</aside>
		<?php endif; ?>
		
		<footer>
			<p><a href="about/copyright" class="ajaxHTML"><?php echo $this->config->item('site_name')?> &copy;<?php echo date("Y")?></a></p>
		</footer>
		
	</div>
</body>
</html>