<?PHP

include('main.php');

class Harbor extends Main {

	function index()
	{
		$this->this_place = 'harbor';

		if ($this->user['game']['place'] == 'ocean')
		{
			$data['changeElements'] = array();
		
			//From the ocean to a harbor
			$allowed_towns = array('charles towne', 'biloxi', 'havana', 'villa hermosa', 'belize', 'port royale', 'tortuga', 'leogane', 'san juan', 'st. martin', 'st. eustatius', 'martinique', 'barbados', 'panama', 'curacao', 'bonaire');
			$wanted_town = ($this->uri->segment(2) != "") ? str_replace("_", " ", $this->uri->segment(2)) : FALSE;
			
			if (isset($wanted_town) && in_array($wanted_town, $allowed_towns))
			{
				//Check if the town is OK to visit...
				$updates['town'] = $wanted_town;
				$updates['week']['add'] = TRUE;
				$updates['week']['value'] = 1;
				$this->user['game']['town_human'] = ucwords($wanted_town . ((substr($wanted_town, -1) != 's') ? 's' : ''));

				$new_town = $this->config->item('towns');
				$this->user['game']['nation'] = $new_town[$wanted_town]['nation'];
				$this->user['game']['place'] = $updates['place'] = $this->this_place;

				$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
				$new_mood = $this->user['game']['crew_lowest_mood'] - 1;
				$crew_updates['all']['mood'] = $new_mood;
				$crew_output = $this->Crew->update($crew_updates);
				
				if ($crew_output['success'])
				{
					$data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
				}

				if (rand(1,2) == 1 && empty($this->user['game']['event_ship']) && empty($this->user['game']['event_ocean_trade']) && $this->user['game']['ships'] > 0)
				{
					//Meet a ship!
					$ship_meeting = $this->gamelib->ship_spec($this->user['game']['manned_cannons'], $this->user['game']['nation']);
					$ship_meeting['prisoners'] = ($ship_meeting['nation'] == $this->user['game']['enemy'] || $ship_meeting['nation'] == 'pirate') ? floor(rand(0,2) * rand(0,1)) : 0;
					$this->user['game']['event_ship'] = $updates['event_ship'] = $ship_meeting['nation'] . '###' . $ship_meeting['type'] . '###' . $ship_meeting['crew'] . '###' . $ship_meeting['cannons'] . '###' . $ship_meeting['prisoners'];

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
					$data['changeElements']['nav_ocean']['visibility'] = 'none';
					$data['changeElements']['nav_harbor']['visibility'] = 'block';
					$data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
					$data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
					
					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'landho';	}
				}
				
				$this->user['json'] = json_encode($data);

				$result = $this->Game->update($updates);
				
				$log_input['entry'] = 'traveled to ' . ucwords($wanted_town) . '.';
				$this->Log->create($log_input);
				
				$data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);

				$view = (! empty($this->user['game']['event_ship']) || ! empty($this->user['game']['event_ocean_trade'])) ? 'ocean/view_ship_meeting' : $this->user['game']['place'] . '/view_' . $this->user['game']['place'];
				$this->load->view_ajax($view, $this->user);
			}
			
		}
		else
		{
			//Going to the harbor from the town or page reload
			$town_to_harbor_access = TRUE;
			$data['changeElements'] = array();
			
			if ($this->input->is_ajax_request())
			{
				$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
				$this->user['game']['angry_crew'] = $this->gamelib->report_crew_unhappiness($this->user['crew']);
				$town_to_harbor_access = $this->check_access();
				
				if ($town_to_harbor_access === TRUE)
				{
					$data['changeElements']['nav_dock']['visibility'] = 'none';
					$data['changeElements']['nav_harbor']['visibility'] = 'block';
					$this->user['game']['place'] = $updates['place'] = $this->this_place;
					
					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'wind';	}
				}
				else
				{
					$data['error'] = 'You cannot leave just yet...';
					$this->user['game']['harbor_errors'] = $town_to_harbor_access;
					$data['pushState'] = base_url('dock');
					$this->user['game']['place'] = $updates['place'] = 'dock';
				}
				
				$result = $this->Game->update($updates);
				$data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
				
				$this->user['json'] = json_encode($data);
			}
			
			$view = ($town_to_harbor_access === TRUE) ? $this->user['game']['place'] . '/view_' . $this->user['game']['place'] : 'dock/view_dock';
			$this->load->view_ajax($view, $this->user);
		}

	}

	function check_access()
	{
		$errors = array();
	
		if ($this->user['game']['angry_crew'] > 0)
		{
			$errors[]['smiley_aggressive.png'] = $this->user['game']['angry_crew'] . ' of your crew members are angry and do not want to leave town! You should please them or discard them.';
		}
		
		if ($this->user['game']['crew_members'] < $this->user['game']['min_crew'])
		{
			$errors[]['tavern_sailor'] = 'You need at least ' . $this->user['game']['min_crew'] . ' crew members to sail out. Get more men or sell a ship.';
		}
		
		if ($this->user['game']['crew_members'] > $this->user['game']['max_crew'])
		{
			$errors[]['tavern_sailor'] = 'Your ship only supports ' . $this->user['game']['max_crew'] . ' crew members at this time. Discard crew members or buy more ships.';
		}
		
		if ($this->user['game']['ships'] < 1)
		{
			$errors[]['shipyard_sell'] = 'You don\'t own a ship. You should buy one. Take a loan if you cannot afford it.';
		}
		
		if ($this->user['game']['load_left'] < 0)
		{
			$errors[]['shipyard_sell'] = 'Your ship can only carry ' . $this->user['game']['load_max'] . ' cartons, and you carry ' . $this->user['game']['load_current'] . '.';
		}
		
		if ($this->user['game']['cannons'] > $this->user['game']['max_cannons'])
		{
			$errors[]['shipyard_fixings'] = 'You cannot load more than ' . $this->user['game']['max_cannons']. ' cannons! Sell some cannons or buy new ships.';
		}
		
		if ($this->user['game']['food'] < $this->user['game']['needed_food'])
		{
			$errors[]['market_browse'] = 'You need at least ' . $this->user['game']['needed_food'] . ' cartons of food, or you will starve out there.';
		}
		
		if ($this->user['game']['water'] < $this->user['game']['needed_water'])
		{
			$errors[]['water'] = 'You need at least ' . $this->user['game']['needed_water'] . ' barrels of water, or you will thirst do death out there.';
		}
		
		if (count($errors) > 0)
		{
			return $errors;
		}
		else
		{
			return TRUE;
		}
	}
	
}

/*  End of harbor.php */
/* Location: ./application/controllers/harbor.php */