<?PHP

include('Main.php');

class Ocean extends Main {

	function index()
	{
		$this->this_place = 'ocean';
		$accepted_places = array('harbor', 'ocean');
		$data['changeElements'] = array();
		
		$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
		$angry_crew = $this->gamelib->report_crew_unhappiness($this->user['crew']);
		$view = ($this->user['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';

		if ($this->input->is_ajax_request())
		{
			//Ajax request, make stuff happen
			if (! in_array($this->user['game']['place'], $accepted_places) || ! empty($this->user['game']['event_ship']) || ! empty($this->user['game']['event_ocean_trade']))
			{
				//Do nothing...
			}
			elseif ($this->user['game']['ships'] < 1)
			{
				$data['error'] = 'You do not own a ship. This is no time for exploring the ocean. Please paddle to a close town!';
			}
			elseif ($this->user['game']['crew_members'] < 1)
			{
				$data['error'] = 'You don\'t have any crew members! This is no time for exploring the ocean. Please sail to a town near by!';
			}
			elseif ($angry_crew > 0)
			{
				$data['error'] = $angry_crew . ' of your crew members are angry and do not want to travel any more! You can land your ship at the closest town, give them something to make them less angry, or just discard them.';
			}
			elseif ($this->user['game']['food'] - $this->user['game']['needed_food'] <= 0)
			{
				$data['error'] = 'You do not have enough food to keep on traveling. Please go to the closest harbor and stock up some food.';
			}
			elseif ($this->user['game']['water'] - $this->user['game']['needed_water'] <= 0)
			{
				$data['error'] = 'You do not have enough water to keep on traveling. Please go to the closest harbor and stock up some water.';
			}
			else
			{
				//Everything is OK for traveling to the ocean!
				if (rand(1,2) == 1 && empty($this->user['game']['event_ship']) && empty($this->user['game']['event_ocean_trade']) && $this->user['game']['ships'] > 0)
				{
					//Meet a ship!
					$ship_meeting = $this->gamelib->ship_spec($this->user['game']['manned_cannons'], $this->user['game']['nation']);
					$ship_meeting['prisoners'] = ($ship_meeting['nation'] == $this->user['game']['enemy'] || $ship_meeting['nation'] == 'pirate') ? floor(rand(0,2) * rand(0,1)) : 0;
					$this->user['game']['event_ship'] = $ship_meeting['nation'] . '###' . $ship_meeting['type'] . '###' . $ship_meeting['crew'] . '###' . $ship_meeting['cannons'] . '###' . $ship_meeting['prisoners'];
					$updates['event_ship'] = $this->user['game']['event_ship'];
					
					$data['changeElements']['nav_ocean']['visibility'] = 'none';
					$data['changeElements']['nav_harbor']['visibility'] = 'none';
					$data['changeElements']['nav_dock']['visibility'] = 'none';

					$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = ($ship_meeting['nation'] == 'pirate' || $ship_meeting['nation'] == $this->user['game']['enemy']) ? 'block' : 'none';
					$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = ($ship_meeting['nation'] == $this->user['game']['nationality']) ? 'block' : 'none';
					$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = ($ship_meeting['nation'] != 'pirate' && $ship_meeting['nation'] != $this->user['game']['nationality'] && $ship_meeting['nation'] != $this->user['game']['enemy']) ? 'block' : 'none';

					$data['pushState'] = base_url('ocean/ship_meeting');
					
					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'sailho';	}
				}
				else
				{
					$data['changeElements']['nav_ocean']['visibility'] = 'block';
					$data['changeElements']['nav_harbor']['visibility'] = 'none';
					$data['changeElements']['nav_dock']['visibility'] = 'none';
					
					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'wind';	}
				}

				if ($this->user['game']['place'] != $this->this_place)
				{
					//If you are comming from the harbor
					$updates['event_work'] = '';
					$updates['event_market_goods'] = '';
					$updates['event_market_slaves'] = '';
					$updates['event_sailors'] = '';

					$log_input['entry'] = 'leaves the port of ' . ucwords($this->user['game']['town']) . ' to explore the caribbean sea.';
					$this->Log->create($log_input);
					
					$this->user['game']['town'] = $updates['town'] = $this->this_place;
					$this->user['game']['place'] = $updates['place'] = $this->this_place;
				}

				$updates['food']['sub'] = TRUE;
				$updates['food']['value'] = $this->user['game']['needed_food'];
				$updates['water']['sub'] = TRUE;
				$updates['water']['value'] = $this->user['game']['needed_water'];
				$updates['week']['add'] = TRUE;
				$updates['week']['value'] = 1;
				
				$new_mood = $this->user['game']['crew_lowest_mood'] - 1;
				$updates['all']['mood'] = $new_mood;
				$crew_output = $this->Crew->update($updates);
				
				if ($crew_output['success'])
				{
					$data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
				}
				
				$result = $this->Game->update($updates);
				$data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
			}
		}
		
		$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
		$this->user['json'] = json_encode($data);
		
		$view = (! empty($this->user['game']['event_ship']) || ! empty($this->user['game']['event_ocean_trade'])) ? 'ocean/view_ship_meeting' : $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
		$this->load->view_ajax($view, $this->user);
	}
	
	function ship_meeting()
	{
		if (! empty($this->user['game']['event_ship']))
		{
			$this->this_place = 'ocean';
			$accepted_places = array('harbor', 'ocean');
			
			$data['changeElements']['nav_ocean']['visibility'] = 'none';
			$data['changeElements']['nav_harbor']['visibility'] = 'none';
			$data['changeElements']['nav_dock']['visibility'] = 'none';
			
			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			
			$this->user['json'] = json_encode($data);
			
			$this->load->view_ajax('ocean/view_ship_meeting', $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function attack()
	{
		if (! empty($this->user['game']['event_ship']) || ! empty($this->user['game']['flee_fail']))
		{
			$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
		
			list($nation, $type, $crew, $cannons, $prisoners) = explode('###', $this->user['game']['event_ship']);

			if ($this->user['game']['manned_cannons'] < 6) { $variation = 0.4; }
			else if ($this->user['game']['manned_cannons'] >= 6 && $this->user['game']['manned_cannons'] < 12) { $variation = 0.2; }
			else { $variation = 0.1; }

			$my_chances = $this->user['game']['manned_cannons'] + rand(0,floor($this->user['game']['manned_cannons'] * $variation));
			$enemy_chances = $cannons + rand(0,floor($cannons * $variation));
			$my_chances = ($my_chances == $enemy_chances) ? $my_chances + 1 : $my_chances;

			if ($my_chances >= $enemy_chances)
			{
				//Win the battle!
				$this->user['game']['event_ship_won'] = 'You win the battle after a violent fight!';
				if (isset($this->user['game']['flee_fail']))
				{
					$this->user['game']['event_ship_won'] = $this->user['game']['flee_fail'] . ' ' . $this->user['game']['event_ship_won'];
				}

				$log_msg = ($nation == 'pirate') ? 'meets a pirate ship' : 'meets a ship from ' . $nation;
				$log_msg .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons. The battle is won!';

				//Loot some money
				$looted_money = ($crew * rand(10,100));
				$this->user['game']['event_ship_won'] .= '###' . $looted_money;
				
				$updates['doubloons']['add'] = TRUE;
				$updates['doubloons']['value'] = $looted_money;
				
				$log_msg .= ' ' . $looted_money . ' doubloons is taken.';

				//Give the crew some money too, and increase mood
				$crew_money = floor(($looted_money / 2) / $this->user['game']['crew_members']);
				$crew_updates['all']['doubloons'] = "+" . $crew_money;
				$crew_updates['all']['mood'] = "+2";
				$crew_updates['all']['health'] = rand(-8, -1);

				//Ship health decrease
				$ship_updates['all']['health'] = rand(-8, -1);

				//Put the number of victories one step up
				$victory_nation = ($nation == 'pirate') ? 'pirates' : $nation;
				
				$updates['victories_' . $victory_nation]['add'] = TRUE;
				$updates['victories_' . $victory_nation]['value'] = 1;

				//Go through some items to see what we will be able to loot
				$item_list = array('food' => 'cartons', 'water' => 'barrels', 'porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
				foreach ($item_list as $item => $container)
				{
					if (rand(0,2) == 0)
					{
						$found_amount = ($item == 'food' || $item == 'water') ? $crew * rand(1,10) : $crew * rand(1,5);
						$this->user['game']['event_ship_won'] .= '###' . $found_amount;
					}
					else
					{
						$this->user['game']['event_ship_won'] .= '###0';
					}
				}

				if ($crew < 11)
				{
					$new_crew = floor($crew * (rand(10,40) / 100));
				}
				elseif ($crew > 11 || $crew < 20)
				{
					$new_crew = floor($crew * (rand(3,10) / 100));
				}
				else
				{
					$new_crew = floor($crew * (rand(2,6) / 100));
				}
				
				$this->user['game']['event_ship_won'] .= '###' . $new_crew;

				if ($prisoners > 0)
				{
					$updates['prisoners']['add'] = TRUE;
					$updates['prisoners']['value'] = $prisoners;
					$log_msg .= ' ' . $prisoners . ' men were taken as prisoners.';
				}

				$this->user['game']['event_ship_won'] .= '###' . $prisoners;
				
				$data['changeElements']['nav_ocean']['visibility'] = 'none';
				$data['changeElements']['nav_harbor']['visibility'] = 'none';
				$data['changeElements']['nav_dock']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
			}
			else
			{
				//You lose the battle
				$this->user['game']['lost'] = 'You\'ve lost the battle!';
				if (isset($this->user['game']['flee_fail']))
				{
					$this->user['game']['lost'] = $this->user['game']['flee_fail'] . ' ' . $this->user['game']['lost'];
				}
				
				$data['changeElements'] = array();

				$log_msg = ($nation == 'pirate') ? 'meets a pirate ship' : 'meets a ship from ' . $nation;
				$log_msg .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons. Unfortunately the battle is lost!';

				//Go through your inventory and take things
				$items = array('food' => 'cartons', 'water' => 'barrels', 'porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
				foreach ($items as $item => $container)
				{
					if ($this->user['game'][$item] > 0)
					{
						$updates[$item]['value'] = ($this->user['game']['ships'] <= 1) ? 0 : $this->user['game'][$item] - floor($this->user['game'][$item] / $this->user['game']['ships']);
						$this->user['game']['bad'][$item] = 'They took ' . floor($this->user['game'][$item] / $this->user['game']['ships']) . ' ' . $container . ' of ' . $item . ' from you.';
					}
				}

				if ($this->user['game']['doubloons'] > 0)
				{
					//Take your money if you have any...
					$this->user['game']['bad']['bank'] = 'They took ' . $this->user['game']['doubloons'] . ' doubloons from you.';
					$updates['doubloons']['value'] = 0;
				}

				$sink_ship = ($this->user['game']['ships'] > 1) ? rand(1,3) : rand(1,4);
				if ($sink_ship == 1)
				{
					//Don't sink ship
					$log_msg .= ' The ship is not sunk, but they take all money and loots the goods.';
				}
				else
				{
					//Sink ship
					$random_key = array_rand($this->user['ship']);
					$sunken_ship = $this->user['ship'][$random_key];
					
					$ship_result = $this->Ship->erase(array('id' => $sunken_ship['id']));
					
					$this->user['game']['ships'] = $ship_result['ships'];
					$data['changeElements'] = array_merge($data['changeElements'], $ship_result['changeElements']);
					
					$this->user['game']['bad']['coast'] = 'They sink your ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . '.';

					if ($this->user['game']['ships'] > 0)
					{
						//You've got more ships so your cool...
						$log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take all money and loots some of the goods.';
					}
					else
					{
						//No more ships, shit...
						if ($this->user['game']['rafts'] > 0)
						{
							//Phew, you got rafts...
							$used_rafts = (floor($this->user['game']['crew_members'] / 10) < 1) ? 1 : floor($this->user['game']['crew_members'] / 10);
							$used_rafts = ($used_rafts > $this->user['game']['rafts']) ? $this->user['game']['rafts'] : $used_rafts;
							$data['changeElements']['inventory_rafts']['text'] = $this->user['game']['rafts'] - $used_rafts;

							$rafts_holds = $this->user['game']['rafts'] * 10;
							$surviving_crew = ($rafts_holds >= $this->user['game']['crew_members']) ? $this->user['game']['crew_members'] : $rafts_holds;
							$surviving_crew = ($surviving_crew > $this->user['game']['crew_members']) ? $this->user['game']['crew_members'] : $surviving_crew;
							$killed_crew = $this->user['game']['crew_members'] - $surviving_crew;
							
							$updates['rafts']['sub'] = TRUE;
							$updates['rafts']['value'] = $used_rafts;

							$crew_input['user_id'] = $this->user['user']['id'];
							$crew_input['delete_random'] = $killed_crew;
							$crew_result = $this->Crew->erase($crew_input);
							
							$data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
							
							$manned_cannons = (floor($this->user['game']['crew_members'] / 2) > $this->user['game']['cannons']) ? $this->user['game']['cannons'] : floor($this->user['game']['crew_members'] / 2);
							$data['changeElements']['inventory_manned_cannons']['text'] = $manned_cannons;
							
							$killed_msg = ($killed_crew > 0) ? $killed_crew . ' crew members.' : 'all crew members.';
							$log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take everything. ' .  $used_rafts . ' rafts are used to save yourself and ' . $killed_msg;
						}
						else
						{
							//Crap, now you have to swim to land alone
							
							//Delete all crew members
							$crew_input['user_id'] = $this->user['user']['id'];
							$crew_input['delete_all'] = TRUE;
							$crew_result = $this->Crew->erase($crew_input);
							
							$data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
							
							$data['changeElements']['inventory_cannons']['text'] = 0;
							$data['changeElements']['inventory_prisoners']['text'] = 0;
							$data['changeElements']['inventory_manned_cannons']['text'] = 0;

							//Get a new town to be stranded at
							$nation_info = $this->gamelib->get_nations('random');
							$new_town = $nation_info['towns'][array_rand($nation_info['towns'])];

							$updates['town'] = $new_town;
							$updates['place'] = 'dock';
							$updates['prisoners']['value'] = 0;
							
							$this->user['game']['place'] = $updates['place'];

							$log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take everything. All your ships are gone, no rafts, and all crew members are dead. This poor ' . $this->user['game']['title'] . ' are washed up at ' . ucfirst($new_town) . ' docks.';
						}
					}
				}
				
				//Give crew less health and decrease mood
				$crew_updates['all']['health'] = rand(-20, -1);
				$crew_updates['all']['mood'] = -1;
				
				//Ship health decrease
				$ship_updates['all']['health'] = rand(-20, -1);
				
				$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
				$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
				$data['changeElements']['nav_dock']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
				
				$data['pushState'] = base_url($this->user['game']['place']);
			}
			
			//Below is happening either you win or lose
			
			//Ship health decrease
			$ship_output = $this->Ship->update($ship_updates);

			if (! empty($this->user['game']['event_ship_won'])) { $this->user['game']['event_ship_won'] .= '###' . $ship_output['ship_destroyed_count']; }

			if ($ship_output['ship_destroyed_count'] > 0)
			{
				$log_msg .= ' ' . $ship_output['ship_destroyed_count'] . ' ships crashed because of ship damages!';
				$this->user['game']['bad']['coast'] = $ship_output['ship_destroyed_count'] . ' of your ships crashed because of ship damages!';
			}
			
			$data['changeElements'] = array_merge($data['changeElements'], $ship_output['changeElements']);

			//Give crew less health and decrease mood
			$crew_output = $this->Crew->update($crew_updates);
			$this->user['game']['crew_members'] = $crew_output['num_crew'];
			
			if (! empty($this->user['game']['event_ship_won'])) { $this->user['game']['event_ship_won'] .= '###' . $crew_output['death_count']; }

			if ($crew_output['death_count'] > 0)
			{
				$this->user['game']['bad']['tavern_sailor'] = $crew_output['death_count'] . ' of your crew members died in battle.';
				$log_msg .= ' However, ' . $crew_output['death_count'] . ' of crew members died in battle.';
			}
			
			$data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);

			if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'cannons';	}
			
			$this->user['game']['crew_members'] = $crew_output['num_crew'];
			$this->user['game']['crew_health_lowest'] = $crew_output['min_health'];
			$this->user['game']['crew_lowest_mood'] = $crew_output['min_mood'];
			
			$this->user['game']['event_ship'] = $updates['event_ship'] = '';
			$updates['event_ship_won'] = (! empty($this->user['game']['event_ship_won'])) ? $this->user['game']['event_ship_won'] : '';

			$game_result = $this->Game->update($updates);
			$data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
	
			$controller = $this->event_method($this->user['game']);
			if ($controller)
			{
				$data['pushState'] = base_url($controller);
			}
			
			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			
			$this->user['json'] = json_encode($data);

			$log_input['entry'] = $log_msg;
			$this->Log->create($log_input);
			
			if (! empty($this->user['game']['event_ship'])) { $view = 'ocean/view_ship_meeting'; }
			elseif (! empty($this->user['game']['event_ocean_trade'])) { $view = 'ocean/view_ocean_trade'; }
			elseif (! empty($this->user['game']['event_ship_won'])) { $view = 'ocean/view_ship_won'; }
			else { $view = 'ocean/view_ocean'; }
			$this->load->view_ajax($view, $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}
	
	function ship_won()
	{
		if (! empty($this->user['game']['event_ship_won']))
		{
			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			$this->user['json'] = json_encode($data);
			$this->load->view_ajax('ocean/view_ship_won', $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function ship_won_transfer()
	{
		if (! empty($this->user['game']['event_ship_won']))
		{
			$data['changeElements'] = array();
			$data['success'] = '';
			$log_input['entry'] = '';
			$total_load = $this->user['game']['load_current'];
			list($event['msg'], $event['doubloons'], $event['food'], $event['water'], $event['porcelain'], $event['spices'], $event['silk'], $event['medicine'], $event['tobacco'], $event['rum'], $event['new_crew'], $event['prisoners']) = explode("###", $this->user['game']['event_ship_won']);
			$updates = array();
			$items = array('food' => 16, 'water' => 12, 'porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);

			foreach ($items as $item => $cost)
			{
				$new_quantity = $this->input->post($item . '_new_quantity');
				$max_quantity = $this->user['game'][$item] + $event[$item];
				$current_quantity = $this->user['game'][$item];

				if ($new_quantity > $current_quantity && $new_quantity <= $max_quantity)
				{
					//The item is not the same as in $game, and prevent cheating
					$updates[$item]['value'] = $new_quantity;
					$data['changeElements']['inventory_' . $item]['text'] = $new_quantity;
					$item_msg[] = 'looted ' . ($new_quantity - $current_quantity) . ' cartons of ' . $item;
					$total_load += ($new_quantity - $current_quantity);
				}
			}
			
			$new_crew = $this->input->post('crew_new_quantity') - $this->user['game']['crew_members'];

			if ($total_load > $this->user['game']['load_max'])
			{
				$data['error'] = 'Your ships cannot load that much!';
				$view = 'ocean/view_ship_won';
			}
			elseif ($new_crew > 0 && ($this->user['game']['crew_members'] + $new_crew > $this->user['game']['max_crew']))
			{
				$data['error'] = 'Your ships cannot hold more than ' . $this->user['game']['max_crew'] . ' crew members';
				$view = 'ocean/view_ship_won';
			}
			elseif (count($updates) < 1 && $new_crew < 1)
			{
				$data['info'] = 'You decided not to loot anything.';
				
				$updates['event_ship_won'] = '';
				$this->Game->update($updates);
				
				$view = 'ocean/view_ship_won';

				$this->user['game']['event_ship_won'] = $updates['event_ship_won'] = '';
			}
			else
			{
				if (isset($item_msg))
				{
					$item_msg = $this->gamelib->readable_list($item_msg);
					$data['success'] .= 'You ' . $item_msg . '.';
					$log_input['entry'] .= $item_msg;
				}
			
				$this->user['game']['load_current'] = $total_load;

				if ($new_crew > 0)
				{
					$data['success'] .= ' ' . $new_crew . ' sailors were taken in as crew members.';
					$log_input['entry'] .= ' ' . $new_crew . ' sailors were taken in as crew members.';
					
					$crew_input['user_id'] = $this->user['user']['id'];
					$crew_input['number_of_men'] = $new_crew;
					$crew_input['week'] = $this->user['game']['week'];
					$crew_input['nationality'] = 'random';
					$crew_input['health'] = rand(50,100);
					$crew_result = $this->Crew->create($crew_input);
					
					$data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
				}
				
				$this->user['game']['event_ship_won'] = $updates['event_ship_won'] = '';
				
				$game_result = $this->Game->update($updates);
				$data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
				
				if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'cheering';	}

				if (! empty($data['success']))
				{
					$this->Log->create($log_input);
				}
				
				$view = $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
			}
			
			$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
			$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
			$data['changeElements']['nav_dock']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
			
			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			$data['loadView'] = $this->load->view($view, $this->user, TRUE);
			$data['pushState'] = base_url($this->user['game']['place']);
			
			echo json_encode($data);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function ship_won_cancel()
	{
		if (! empty($this->user['game']['event_ship_won']))
		{
			$this->user['game']['event_ship_won'] = $updates['event_ship_won'] = '';
			$this->user['game']['event_ship'] = $updates['event_ship'] = '';
			$result = $this->Game->update($updates);
			
			$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
			$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
			$data['changeElements']['nav_dock']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
			
			$data['info'] = 'You decided not to loot anything.';
			
			$data['pushState'] = base_url($this->user['game']['place']);
			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			
			$this->user['json'] = json_encode($data);
			
			$view = $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
			$this->load->view_ajax($view, $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function ignore()
	{
		if (! empty($this->user['game']['event_ship']))
		{
			list($nation, $type, $crew, $cannons, $prisoners) = explode('###', $this->user['game']['event_ship']);

			$this->user['game']['event_ship'] = $updates['event_ship'] = '';

			$result = $this->Game->update($updates);

			$data['info'] = ($nation == 'pirate') ? 'You ignored a pirate ship' : 'You ignored a ship from ' . ucfirst($nation);
			$data['info'] .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons.';
			
			$log_input['entry'] = ($nation == 'pirate') ? 'ignored a pirate ship' : 'ignored a ship from ' . ucfirst($nation);
			$log_input['entry'] .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons.';
			$this->Log->create($log_input);
			
			$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
			$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
			$data['changeElements']['nav_dock']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

			$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
			$data['pushState'] = base_url($this->user['game']['place']);
			
			$this->user['json'] = json_encode($data);

			$view = ($this->user['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
			$this->load->view_ajax($view, $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function flee()
	{
		if (! empty($this->user['game']['event_ship']))
		{
			list($nation, $type, $crew, $cannons, $prisoners) = explode('###', $this->user['game']['event_ship']);

			if (rand(1,4) == 1)
			{
				$this->user['game']['flee_fail'] = 'You tried to flee from a ' . $type . ' from ' . $nation . ' with ' . $crew  . ' crew members and ' . $cannons . ' cannons, but did not succeed.';
				$this->attack($this->user);
			}
			else
			{
				$this->user['game']['event_ship'] = $updates['event_ship'] = '';

				$result = $this->Game->update($updates);

				$data['info'] = ($nation == 'pirate') ? 'You fled from a pirate ship' : 'You fled from a ship from ' . $nation;
				$data['info'] .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons.';
				
				$log_input['entry'] = ($nation == 'pirate') ? 'fled from a pirate ship' : 'fled from a ship from ' . $nation;
				$log_input['entry'] .= ' with ' . $crew . ' crew members and ' . $cannons . ' cannons.';
				$this->Log->create($log_input);

				$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
				$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
				$data['changeElements']['nav_dock']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

				$data['pushState'] = base_url($this->user['game']['place']);
				$data['loadJSFile'] = base_url('assets/javascript/ocean.js');

				$this->user['json'] = json_encode($data);
				
				$view = (! empty($this->user['game']['event_ship']) || ! empty($this->user['game']['event_ocean_trade'])) ? 'ocean/view_ship_meeting' : $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
				$this->load->view_ajax($view, $this->user);

			}
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function trade()
	{
		if (! empty($this->user['game']['event_ship']))
		{
			list($nation, $type, $crew, $cannons) = explode('###', $this->user['game']['event_ship']);
			if ($nation == $this->user['game']['nationality'])
			{
				$trade_worth = 0;
				$barter_goods = array('porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);

				foreach($barter_goods as $item => $worth)
				{
					if ($this->user['game'][$item] > 0)
					{
						$trade_worth += $this->user['game'][$item] * $worth;
					}
				}

				if ($trade_worth > 0)
				{
					$this->user['game']['event_ocean_trade'] = $trade_worth;
					$updates['event_ocean_trade'] = $trade_worth;
					
					$data['changeElements']['nav_ocean']['visibility'] = 'none';
					$data['changeElements']['nav_harbor']['visibility'] = 'none';
					$data['changeElements']['nav_dock']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
				}
				else
				{
					$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
					$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
					$data['changeElements']['nav_dock']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

					$view = ($this->user['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
					$data['loadView'] = $this->load->view($view, $this->user, TRUE);
					$data['pushState'] = base_url($this->user['game']['place']);
					
					$updates['event_ship'] = '';
				
					$data['info'] = 'It was nice speakin\' to you, ' . $this->user['game']['character_name'] . ', but you don\'t have anything I could use...';
				}
				
				$result = $this->Game->update($updates);
				
				$data['loadJSFile'] = base_url('assets/javascript/ocean.js');
				$this->user['json'] = json_encode($data);

				$this->load->view_ajax('ocean/view_ocean_trade', $this->user);
			}
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function trade_transfer()
	{
		if (! empty($this->user['game']['event_ocean_trade']))
		{
			$items = array('food' => 16, 'water' => 12);
			$trade_worth = $this->user['game']['event_ocean_trade'];
			$total_cost = 0;
			$total_load = $this->user['game']['load_current'];
			$msg_get_list = array();
			$msg_away_list = array();

			foreach ($items as $item => $cost)
			{
				$new_quantity = $this->input->post($item . '_new_quantity');
				$current_quantity = $this->user['game'][$item];

				if ($new_quantity > $current_quantity)
				{
					$total_cost += floor($new_quantity - $current_quantity) * $cost;
					$updates[$item]['value'] = $new_quantity;
					$msg_get_list[] = floor($new_quantity - $current_quantity) . ' cartons of ' . $item;
					$total_load += $new_quantity - $current_quantity;
				}
			}

			if (($trade_worth - floor($total_cost)) < 0)
			{
				$data['error'] = 'You don\'t have that much barter goods to trade with!';
				echo json_encode($data);
			}
			elseif (($this->user['game']['load_max'] - $total_load) < 0)
			{
				$data['error'] = 'Your ships cannot load that much!';
				echo json_encode($data);
			}
			else
			{
				$this->user['game']['load_current'] = $total_load;
				$this->user['game']['event_ocean_trade'] = $updates['event_ocean_trade'] = '';
				$this->user['game']['event_ship'] = $updates['event_ship'] = '';

				$barter_goods = array('porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);
			
				foreach ($barter_goods as $item => $cost)
				{
					if ($total_cost > 0)
					{
						$item_trade_away = ($this->user['game'][$item] * $cost < $total_cost) ? $this->user['game'][$item] : ceil($total_cost / $cost);

						if ($item_trade_away > 0)
						{
							$this->user['game'][$item] -= $item_trade_away;
							$updates[$item] = $this->user['game'][$item];
							$msg_away_list[] = $item_trade_away . ' cartons of ' . $item;
							$total_cost -= $item_trade_away * $cost;
						}
						
						if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'coins';	}
					}
				}

				if (count($msg_away_list) > 0 && count($msg_get_list) > 0)
				{
					$msg_away = $this->gamelib->readable_list($msg_away_list);
					$msg_get = $this->gamelib->readable_list($msg_get_list);
					$data['success'] = 'You traded away ' . $msg_away . ' for ' . $msg_get . '.';
					
					$log_input['entry'] = 'traded away ' . $msg_away . ' for ' . $msg_get . ' with an allied ship.';
					$this->Log->create($log_input);
				}
				else
				{
					$data['info'] = 'You decided not to trade anything.';
				}

				$result = $this->Game->update($updates);
				$data['changeElements'] = $result['changeElements'];
				
				$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
				$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
				$data['changeElements']['nav_dock']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
				$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
				
				$view = ($this->user['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
				$data['loadView'] = $this->load->view($view, $this->user, TRUE);
				$data['pushState'] = base_url($this->user['game']['place']);
				$data['loadJSFile'] = base_url('assets/javascript/ocean.js');

				echo json_encode($data);
			}
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

	function trade_cancel()
	{
		if (! empty($this->user['game']['event_ocean_trade']))
		{
			$this->user['game']['event_ocean_trade'] = $updates['event_ocean_trade'] = '';
			$this->user['game']['event_ship'] = $updates['event_ship'] = '';
			$result = $this->Game->update($updates);
			
			$data['info'] = 'You canceled the trading, said good buy to your allies.';
			
			$data['changeElements']['nav_ocean']['visibility'] = ($this->user['game']['place'] == 'ocean') ? 'block' : 'none';
			$data['changeElements']['nav_harbor']['visibility'] = ($this->user['game']['place'] == 'harbor') ? 'block' : 'none';
			$data['changeElements']['nav_dock']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
			$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
			
			$this->user['json'] = json_encode($data);

			$view = $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
			$this->load->view_ajax($view, $this->user);
		}
		else
		{
			redirect(base_url($this->user['game']['place']));
		}
	}

}

/*  End of ocean.php */
/* Location: ./application/controllers/ocean.php */