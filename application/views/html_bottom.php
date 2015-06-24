		</article>
		
		<? if (isset($user)): ?>
			<? /* For logged in users! */ ?>

			<aside id="inventory_panel" class="grid_2">
				<h3>Inventory</h3>
				
				<? if ( ! isset($no_menu)): ?>
					<div class="inventory_user">
						<a class="ajaxHTML" href="inventory/player/<?=$user['id']?>#character">
							<div style="height: 100%; width: 40px">
								<img id="inventory_character_avatar" src="<?=$game['character_avatar_thumb_path']?>" alt="Character avatar" width="120" height="120">
							</div>
							<div style="width: 100%;">
								<span id="inventory_character_name"><?=$game['character_name']?></span>, <span id="inventory_title"><?=$game['title']?></span> from <span id="inventory_nationality"><?=ucwords($game['nationality'])?></span>
							</div>
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($user['new_messages'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="You have new messages!" href="inventory/messages/<?=$user['id']?>">
							<img src="<?=base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="24" height="24">
							<span id="inventory_new_messages"><?=$user['new_messages']?></span> <?=($user['new_messages'] > 1) ? 'messages' : 'message'; ?>
						</a>
					</div>
					
					<? if ($game['crew_health_lowest'] <= 25) { $crew_health_symbol = 'crew_health_25'; } ?>
					<? if ($game['crew_health_lowest'] > 25 && $game['crew_health_lowest'] <= 50) { $crew_health_symbol = 'crew_health_50'; } ?>
					<? if ($game['crew_health_lowest'] > 50 && $game['crew_health_lowest'] <= 75) { $crew_health_symbol = 'crew_health_75'; } ?>
					<? if ($game['crew_health_lowest'] > 75) { $crew_health_symbol = 'crew_health_100'; } ?>
				
					<? if ($game['ship_health_lowest'] <= 25) { $ship_health_symbol = 'ship_health_25'; } ?>
					<? if ($game['ship_health_lowest'] > 25 && $game['ship_health_lowest'] <= 50) { $ship_health_symbol = 'ship_health_50'; } ?>
					<? if ($game['ship_health_lowest'] > 50 && $game['ship_health_lowest'] <= 75) { $ship_health_symbol = 'ship_health_75'; } ?>
					<? if ($game['ship_health_lowest'] > 75) { $ship_health_symbol = 'ship_health_100'; } ?>
					
					<!-- Section: Game status -->
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_crew_health_link" title="You have <?=$game['crew_members']?> crew members with the health <?=$game['crew_health_lowest']?>%" href="inventory/crew/<?=$user['id']?>">
							<img id="inventory_crew_health_img" src="<?=base_url('assets/images/icons/' . $crew_health_symbol . '.png')?>" alt="Crew" width="24" height="24">
							<span id="inventory_crew"><?=$game['crew_members']?></span> men
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['crew_members'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" id="inventory_crew_mood_link" title="Your crew is <?=$game['crew_lowest_friendly_mood']?> (Mood <?=$game['crew_lowest_mood']?>)" href="inventory/crew/<?=$user['id']?>">
							<img id="inventory_crew_mood_img" src="<?=base_url('assets/images/icons/smiley_' . $game['crew_lowest_friendly_mood'] . '.png')?>" alt="Mood" width="24" height="24">
							<span id="inventory_crew_mood"><?=$game['crew_lowest_friendly_mood']?></span>
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Doubloons that you can use immediately" href="inventory/player/<?=$user['id']?>#capital">
							<img src="<?=base_url('assets/images/icons/bank.png')?>" alt="Money" width="24" height="24">
							<span id="inventory_doubloons"><?=$game['doubloons']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['bank_account'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Doubloons in your bank account" href="inventory/player/<?=$user['id']?>#capital">
							<img src="<?=base_url('assets/images/icons/money_bank.png')?>" alt="Account" width="24" height="24">
							<span id="inventory_bank_account"><?=$game['bank_account']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['bank_loan'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your bank loan amount" href="inventory/player/<?=$user['id']?>#capital">
							<img src="<?=base_url('assets/images/icons/money_bank_loan.png')?>" alt="Bank loan" width="24" height="24">
							<span id="inventory_bank_loan"><?=$game['bank_loan']?></span> dbl
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Amount of weeks that has passed, see log book" href="inventory/log/<?=$user['id']?>">
							<img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="24" height="24">
							week <span id="inventory_week"><?=$game['week']?></span>
						</a>
					</div>
					
					<!-- Section: Ship status -->
					<div style="padding-top: 1em; width: 100%;"></div>					
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_ships_health_link" title="You own <?=$game['ships']?> ships with the health <?=$game['ship_health_lowest']?>%" href="inventory/ships/<?=$user['id']?>">
							<img id="inventory_ships_health_img" src="<?=base_url('assets/images/icons/' . $ship_health_symbol . '.png')?>" alt="Ships" width="24" height="24">
							<span id="inventory_ships"><?=$game['ships']?></span> <?=($game['ships'] > 1) ? 'ships' : 'ship'; ?>
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" id="inventory_cannons_link" title="You own <?=$game['cannons']?> cannons, <?=$game['manned_cannons']?> are manned" href="inventory/ships/<?=$user['id']?>">
							<img src="<?=base_url('assets/images/icons/shipyard_fixings.png')?>" alt="Cannons" width="24" height="24">
							<span id="inventory_manned_cannons"><?=$game['manned_cannons']?></span>/<span id="inventory_cannons"><?=$game['cannons']?></span> cannons
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['rafts'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your life boats, used in shipwreck" href="inventory/ships/<?=$user['id']?>">
							<img src="<?=base_url('assets/images/icons/raft.png')?>" alt="Raft" width="24" height="24">
							<span id="inventory_rafts"><?=$game['rafts']?></span> <?=($game['rafts'] > 1) ? 'rafts' : 'raft'; ?>
						</a>
					</div>
					
					<!-- Section: Stock status -->
					<div style="padding-top: 1em; width: 100%;"></div>	
					
					<div class="inventory_item" style="display: <?=($game['prisoners'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your prisoners, can be left in City Hall for a ransom" href="inventory/ships/<?=$user['id']?>">
							<img src="<?=base_url('assets/images/icons/cityhall_prisoners.png')?>" alt="Prisoners" width="24" height="24">
							<span id="inventory_prisoners"><?=$game['prisoners']?></span> prisoners
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Your food, used by crew members for sea traveling" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="24" height="24">
							<span id="inventory_food"><?=$game['food']?></span> food
						</a>
					</div>
					
					<div class="inventory_item">
						<a class="ajaxHTML" title="Your water, used by crew members for sea traveling" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/water.png')?>" alt="Water" width="24" height="24">
							<span id="inventory_water"><?=$game['water']?></span> water
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['porcelain'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your porcelain, used as barter goods" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/porcelain.png')?>" alt="Porcelain" width="24" height="24">
							<span id="inventory_porcelain"><?=$game['porcelain']?></span> porcelain
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['spices'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your spices, used as barter goods" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/spices.png')?>" alt="Spices" width="24" height="24">
							<span id="inventory_spices"><?=$game['spices']?></span> spices
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['silk'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your silk, used as barter goods" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/silk.png')?>" alt="Silk" width="24" height="24">
							<span id="inventory_silk"><?=$game['silk']?></span> silk
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['medicine'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your medicine, can heal crew members" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/medicine.png')?>" alt="Medicine" width="24" height="24">
							<span id="inventory_medicine"><?=$game['medicine']?></span> medicine
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['tobacco'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your tobacco, used as barter goods and can raise crew members mood" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/tobacco.png')?>" alt="Tobacco" width="24" height="24">
							<span id="inventory_tobacco"><?=$game['tobacco']?></span> tobacco
						</a>
					</div>
					
					<div class="inventory_item" style="display: <?=($game['rum'] > 0) ? 'block' : 'none'?>">
						<a class="ajaxHTML" title="Your rum, used as barter goods and can raise crew members mood" href="inventory/player/<?=$user['id']?>#stock">
							<img src="<?=base_url('assets/images/icons/rum.png')?>" alt="Rum" width="24" height="24">
							<span id="inventory_rum"><?=$game['rum']?></span> rum
						</a>
					</div>
				<? endif; ?>
			</aside>

		<? else: ?>
			<? /* For logged out users! */ ?>
			<aside id="inventory_panel" class="grid_4">
				<form method="post" action="<?=base_url('account/login')?>" style="width: 100%; margin: 0; padding: 0;">
					<fieldset>
						<legend>Log in</legend>
						
						<? if ($this->session->userdata('email') || $this->session->userdata('password')): ?>
								<? $this->session->unset_userdata('email') ?>
								<? $this->session->unset_userdata('password') ?>
								<p style="margin: 0.2em 1em; background: #d96868; padding: 0.3em; border-radius: 4px;">Your login was denied...</p>
						<? endif; ?>
						
						<? if (isset($user['success'])): ?>
								<div class="success"><p>You are now registered with the username: <?=$user['success']?>! Please log in.</p></div>
						<? endif; ?>
						
						<label for="login_email">Email</label>
						<input type="text" id="login_email" name="login_email" autofocus style="width: 100%">
						
						<label for="login_password">Password</label>
						<input type="password" id="login_password" name="login_password" style="width: 100%">
						
						<p style="font-size: 12px; margin: 0 1em;"><a class="ajaxHTML" href="<?=base_url('account/password_forgotten')?>">Have you forgotten your password?</a></p>
						
						<input class="small" type="submit" value="Log in" style="margin-top: 1em;">
					</fieldset>
				</form>
				
				<p>
					<a href="https://www.facebook.com/lostseas" title="Visit us on Facebook"><img src="<?=base_url('assets/images/design/facebook.png')?>" alt="Visit us on facebook"></a>
				</p>
			</aside>
			
			<aside id="log_panel" class="grid_4">
				<h3>What's going on?</h3>
				
				<? if (isset($log_entries)): ?>
					<? unset($log_entries['num_rows']); ?>
					
					<? foreach ($log_entries as $entry): ?>
						<p>
							<img style="float: left; margin: 0.3em 0.5em 0.5em 0; border-radius: 4px;" src="<?=base_url('assets/images/avatars/' . (($entry['character_gender'] == 'M') ? 'male' : 'female') . '_thumb/avatar_' . $entry['character_avatar'] . '.jpg')?>" alt="Avatar of <?=$entry['character_name']?>" width="40" height="40">
							<time style="font-weight: bold"><?=$entry['time']?></time><br>
							<?=$entry['character_name']?> <?=$entry['entry']?>
						</p>
					<? endforeach; ?>
				<? endif; ?>
			</aside>
		<? endif; ?>
		
		<footer>
			<p><a href="about/copyright" class="ajaxHTML">&copy; <?=$this->config->item('site_name')?>, <?=date("Y")?></a></p>
		</footer>
		
	</div>

</body>
</html>