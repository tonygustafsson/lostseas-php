<?PHP

include('Main.php');

class Market extends Main {

	function __construct()
	{
		parent::__construct();

		$this_place = 'market';
		
		if ($this->user['game']['place'] != $this_place)
		{
			$updates['place'] = $this_place;
			$result = $this->Game->update($updates);
			
			if (! isset($result['error']))
			{
				$this->user['game']['place'] = $this_place;
			}
		}
	}

	function index()
	{
		$this->load->view_ajax('market/view_market', $this->user);
	}

	function goods()
	{
		if ($this->user['game']['event_market_goods'] != 'banned')
		{
			list($item, $quantity, $cost, $total_cost) = (! empty($this->user['game']['event_market_goods'])) ? explode('###', $this->user['game']['event_market_goods']) : array(NULL, NULL, NULL, NULL);

			if ($item === NULL || $quantity === NULL || $cost === NULL || $total_cost === NULL)
			{
				$items = array(
					'food' => 16,
					'water' => 12,
					'porcelain' => 35,
					'spices' => 20,
					'silk' => 45,
					'tobacco' => 75,
					'rum' => 150
				);

				$item = array_rand($items);
				$cost = floor($items[$item] * (rand(50, 100) / 100));
				$quantity = rand(1,50);
				$total_cost = $quantity * $cost;

				$this->user['game']['event_market_goods'] = $updates['event_market_goods'] = $item . '###' . $quantity . '###' . $cost . '###' . $total_cost;

				$this->Game->update($updates);
			}

			$this->load->view_ajax('market/view_goods', $this->user);
		}
	}

	function goods_post()
	 {
	 	if (! empty($this->user['game']['event_market_goods']) && $this->user['game']['event_market_goods'] != 'banned')
	 	{
			$data['changeElements'] = array();
			$answer = $this->uri->segment(3);
		
			if ($answer == 'yes')
			{
				list($item, $quantity, $cost, $total_cost) = explode('###', $this->user['game']['event_market_goods']);

				if ($cost <= $this->user['game']['doubloons'])
				{
					$data['success'] = 'You bought ' . $quantity . ' cartons of ' . $item . ' for ' . $total_cost . ' dbl at the market!';

					$updates['event_market_goods'] = 'banned';
					$updates['doubloons']['sub'] = TRUE;
					$updates['doubloons']['value'] = $total_cost;
					$updates[$item]['add'] = TRUE;
					$updates[$item]['value'] = $quantity;
					$result = $this->Game->update($updates);
					
					$data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
					
					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'coins';	}
					
					$log_input['entry'] = 'bought ' . $quantity . ' cartons of ' . $item . ' for ' . $total_cost . ' dbl at the market.';
					$this->Log->create($log_input);
				}
			}
			else
			{
				$data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
			}

			$data['changeElements']['offer']['remove'] = TRUE;
			$data['changeElements']['action_goods']['remove'] = TRUE;
			$data['pushState'] = base_url('market');
			
			echo json_encode($data);
	 	}

	 }

	function slaves()
	{
	 	if ($this->user['game']['event_market_slaves'] != 'banned')
		{
			list($slaves, $health, $cost) = (! empty($this->user['game']['event_market_slaves'])) ? explode('###', $this->user['game']['event_market_slaves']) : array(NULL, NULL, NULL);

			if ($slaves === NULL || $health === NULL || $cost === NULL)
			{
				$slaves = ($this->user['game']['crew_members'] < 10) ? rand(1,3) : rand(1, 12);
				$health = rand(20,100);
				$cost = round($slaves * rand(200, 1200));

				$this->user['game']['event_market_slaves'] = $updates['event_market_slaves'] = $slaves . '###' . $health . '###' . $cost;

				$result = $this->Game->update($updates);
			}

			$this->load->view_ajax('market/view_slaves', $this->user);
		}
	}

	function slaves_post()
	{
	 	if (! empty($this->user['game']['event_market_slaves']) && $this->user['game']['event_market_slaves'] != 'banned')
	 	{
			$answer = $this->uri->segment(3);
			$data['changeElements'] = array();
		
			if ($answer == 'yes')
			{
				list($slaves, $health, $cost) = explode('###', $this->user['game']['event_market_slaves']);

				if ($cost <= $this->user['game']['doubloons'])
				{
					$crew_input['user_id'] = $this->user['user']['id'];
					$crew_input['number_of_men'] = $slaves;
					$crew_input['week'] = $this->user['game']['week'];
					$crew_input['nationality'] = $this->user['game']['nation'];
					$crew_input['health'] = $health;
					$crew_result = $this->Crew->create($crew_input);
					
					if ($crew_result['created_crew_count'] == $slaves)
					{
						$data['success'] = 'You bought ' . $slaves . ' slaves, that is now your crew members, for ' . $cost . ' dbl at the market!';

						$data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);

						$updates['event_market_slaves'] = 'banned';
						$updates['doubloons']['sub'] = TRUE;
						$updates['doubloons']['value'] = $cost;
						$game_result = $this->Game->update($updates);
						$data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
						
						if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'coins';	}
						
						$log_input['entry'] = 'bought ' . $slaves . ' slaves, that is now part of the crew members, for ' . $cost . ' dbl at the market.';
						$this->Log->create($log_input);
					}
					else
					{
						$data['error'] = 'Something went wrong when creating new crew members!';
					}
				}
			}
			else
			{
				$data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
			}

			$data['changeElements']['offer']['remove'] = TRUE;
			$data['changeElements']['action_slaves']['remove'] = TRUE;
			$data['pushState'] = base_url('market');
			
			echo json_encode($data);
	 	}
	}
	
	function healer()
	{
		$injured_crew = 0;
		$total_injury = 0;
		
		$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));

		foreach ($this->user['crew'] as $man)
		{
			if ($man['health'] < 100)
			{
				$injured_crew++;
				$total_injury += 100 - $man['health'];
			}
		}

		$this->user['cost'] = floor($total_injury * 0.75);
		$this->user['injured_crew'] = $injured_crew;

		$this->load->view_ajax('market/view_healer', $this->user);
	}

	function healer_post()
	{
		$answer = $this->uri->segment(3);
		$data['changeElements'] = array();
	
		if ($answer == 'yes')
		{
			$injured_crew = 0;
			$total_injury = 0;		

			$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));

			foreach ($this->user['crew'] as $man)
			{
				if ($man['health'] < 100)
				{
					$injured_crew++;
					$total_injury += 100 - $man['health'];
				}
			}

			$cost = floor($total_injury * 0.75);

			if ($injured_crew > 0 && $cost <= $this->user['game']['doubloons'])
			{
				$crew_updates['all']['health'] = 100;
				$crew_output = $this->Crew->update($crew_updates);

				if ($crew_output['success'])
				{
					$data['success'] = 'You let the towns healer heal ' . $injured_crew . ' of your crew members for ' . $cost . ' dbl!';

					$updates['doubloons']['sub'] = TRUE;
					$updates['doubloons']['value'] = $cost;
					$game_result = $this->Game->update($updates);
					
					$data['pushState'] = base_url('market');
					
					$data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
					
					$data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);

					if ($this->user['user']['sound_effects_play'] == 1)	{ $data['playSound'] = 'healing';	}
					
					$log_input['entry'] = 'let the towns healer heal ' . $injured_crew . ' of the crew members for ' . $cost . ' dbl.';
					$this->Log->create($log_input);
				}
				else
				{
					$data['error'] = 'Something went wrong when healing your crew!';
				}
			}
		}
		else
		{
			$data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
		}

		$data['changeElements']['offer']['remove'] = TRUE;
		
		echo json_encode($data);
	}
}

/*  End of market.php */
/* Location: ./application/controllers/market.php */