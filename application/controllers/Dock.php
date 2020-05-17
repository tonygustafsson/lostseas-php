<?PHP

include('Main.php');

class Dock extends Main {

	function __construct()
	{
		parent::__construct();

		$this_place = 'dock';
		
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
		$data['changeElements'] = array();
	
		$this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
		$new_mood = $this->user['game']['crew_lowest_mood'] + 1;
		$updates['all']['mood'] = $new_mood;
		$crew_output = $this->Crew->update($updates);
		
		if ($crew_output['success'])
		{
			$data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
		}

		if ($this->user['game']['nationality'] == $this->user['game']['nation'])
		{
			$title_input['level'] = $this->user['game']['level'];
			$title_info = $this->gamelib->get_title($title_input);
			$new_title = $title_info['title'];
			$better_than = $title_info['better_than'];

			if ($new_title != $this->user['game']['title'] && in_array($this->user['game']['title'], $better_than))
			{
				$this->user['game']['todo'][]['cityhall_governor'] = 'I\'m sure the towns governor would like to have a word with you!';
			}
		}

		if ($this->user['game']['ships'] < 1)
		{
			$this->user['game']['todo'][]['coast'] = 'You do not own a ship, you must buy a new one! Take a loan if you have to!';
		}

		if ($this->user['game']['ship_health_lowest'] < 80)
		{
			$this->user['game']['todo'][]['coast'] = 'Some of your ships is in need of repair. You should visit the shipyard...';
		}

		if (rand(1,3) == 1 && $this->user['game']['ships'] < 2)
		{
			$this->user['game']['todo'][]['coast'] = 'You only own one ship, which make you vulnerable if you lose a battle. You should save up some money and buy a new one  at the shipyard.';
		}

		if ($this->user['game']['food'] < ($this->user['game']['needed_food'] * 5))
		{
			$this->user['game']['todo'][]['food'] = 'You should buy ' . abs(($this->user['game']['needed_food'] * 5) - $this->user['game']['food']) . ' cartons of food to last 5 more weeks at sea.';
		}

		if ($this->user['game']['water'] < ($this->user['game']['needed_water'] * 5))
		{
			$this->user['game']['todo'][]['water'] = 'You should buy ' . abs(($this->user['game']['needed_water'] * 5) - $this->user['game']['water']) . ' barrels of water if you want to last 5 more weeks at sea.';
		}

		if (floor($this->user['game']['crew_members'] / 2) > $this->user['game']['cannons'])
		{
			$this->user['game']['todo'][]['shipyard_fixings'] = 'You have more crew members than usable cannons, if possible, you should buy ' . (floor($this->user['game']['crew_members'] / 2) - $this->user['game']['cannons']) . ' more cannons.';
		}

		if ($this->user['game']['crew_members'] < 1)
		{
			$this->user['game']['todo'][]['tavern_sailor'] = 'You do not have any crew members, you have to get new onces. Try the tavern or the market!';
		}

		if ($this->user['game']['crew_lowest_mood'] < 6)
		{
			$this->user['game']['todo'][]['tavern_sailor'] = 'Some of your crew is not that happy. You should buy them something to drink before you leave.';
		}

		if ($this->user['game']['crew_health_lowest'] < 80)
		{
			$this->user['game']['todo'][]['tavern_sailor'] = 'Some of your crew is not totally healthy. You should visit the healer, or buy them some dinners at the tavern.';
		}

		if ($this->user['game']['prisoners'] > 0 && $this->user['game']['nation'] == $this->user['game']['nationality'])
		{
			$this->user['game']['todo'][]['cityhall_prisoners'] = 'You have ' . $this->user['game']['prisoners'] . ' prisoners to deliver to the City Hall.';
		}

		$barter_goods = array('porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
		$barter_msg = '';
		foreach ($barter_goods as $item => $container)
		{
			if ($this->user['game'][$item] > 0)
			{
				$barter_msg .= ' ' . $this->user['game'][$item] . ' ' . $container . ' of ' . $item . ',';
			}
		}
		
		if (! empty($barter_msg))
		{
			$this->user['game']['todo'][]['tobacco'] = 'You could sell' . substr($barter_msg, 0, -1) . '.';
		}

		if ($this->user['user']['sound_effects_play'] == 1 && ($this->user['user']['email'] != "" || (time() - strtotime($this->user['user']['created'])) > 180))
		{
			$data['playSound'] = 'cheering';
		}
		
		$data['changeElements']['nav_dock']['visibility'] = 'block';
		$data['changeElements']['nav_harbor']['visibility'] = 'none';
		$this->user['json'] = json_encode($data);

		$this->load->view_ajax('dock/view_dock', $this->user);
	}

}

/*  End of dock.php */
/* Location: ./application/controllers/dock.php */