<?PHP

//The main controller, everything runs through here....

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//$this->output->enable_profiler(TRUE);

		$this->public_page = $this->public_page($this->uri->segment(1), $this->uri->segment(2));
		$this->user = $this->get_user_data();

		//Set HTTP headers
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
		
		if ($this->user || $this->public_page)
		{
			//Get greeting
			$place = ($this->uri->segment(1)) ? $this->uri->segment(1) : $this->user['game']['place'];
			$this->user['game']['greeting'] = $this->gamelib->random_greeting($place, $this->user['game']['character_name'], $this->user['game']['character_gender'], $this->user['game']['character_age']);
		}
		else
		{
			if ($this->uri->segment(1) != "")
			{
				redirect("/account/logged_out");
			}
		}
	}

	function index()
	{
		$event_method = $this->event_method($this->user['game']);
		if ($event_method)
		{
			//An action event
			redirect($event_method);
		}
		elseif (file_exists(APPPATH . 'views/' . $this->user['game']['place'] . '/view_' . $this->user['game']['place'] . '.php'))
		{
			//A page view
			redirect($this->user['game']['place']);
		}
		elseif (! $this->user['user'])
		{
			//Not logged in, accessing start page
			$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
			$this->user['character'] = $this->gamelib->generate_character();
					
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
			
			$this->load->view_ajax('about/view_presentation', $this->user);
		}
		else
		{
			//This place does not exist...
			$data['header'] = 'You are lost!';
			$data['message'] = 'You seem to be at a place that is not supported by the game. Try to reload the page. If it does not work, contact an administrator!';
			$this->load->view_ajax('view_info', $data);
		}

	}

	function public_page($segment1, $segment2)
	{
		$segment1 = (! empty($segment1)) ? $segment1 : 'ROOT';
		$segment2 = (! empty($segment2)) ? $segment2 : 'ROOT';

		$public_pages = array(
			'about' => array('ROOT', 'presentation', 'news', 'news_feed', 'guide_supplies', 'guide_ships', 'guide_crew', 'guide_titles', 'guide_economy', 'guide_traveling', 'guide_players', 'guide_settings', 'ideas', 'send_suggestion', 'tech', 'copyright', '404'),
			'account' => array('ROOT', 'login', 'logout', 'register_temp', 'activate', 'password_forgotten', 'password_send_reset_link', 'generate_character', 'avatar_selector', 'erase_temp_users', 'logged_out'),
			'feed' => array('ROOT')
		);

		if (array_key_exists($segment1, $public_pages))
		{
			if  (in_array($segment2, $public_pages[$segment1]))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}

	}
	
	function event_method($game)
	{
		if (! empty($game['event_market_goods']) && $game['event_market_goods'] != 'banned' && $game['place'] == 'market')
		{
			return 'market';
		}
		elseif (! empty($game['event_market_slaves']) && $game['event_market_slaves'] != 'banned' && $game['place'] == 'market')
		{
			return 'market';
		}
		elseif (! empty($game['event_sailors']) && $game['event_market_slaves'] != 'banned' && $game['place'] == 'tavern')
		{
			return 'tavern';
		}
		elseif (! empty($game['event_work']) && $game['event_work'] != 'banned' && $game['place'] == 'cityhall')
		{
			return 'cityhall';
		}
		elseif (! empty($game['event_ship']) && ($game['place'] == 'ocean' || $game['place'] == 'harbor'))
		{
			return 'ocean/ship_meeting';
		}
		elseif (! empty($game['event_ocean_trade']) && ($game['place'] == 'ocean' || $game['place'] == 'harbor'))
		{
			return 'ocean/trade';
		}
		elseif (! empty($game['event_ship_won']) && ($game['place'] == 'ocean' || $game['place'] == 'harbor'))
		{
			return 'ocean/ship_won';
		}
		else
		{
			return FALSE;
		}
	}

	function get_user_data($user_id = FALSE)
	{
		if ($user_id === FALSE)
		{
			//Get the current user based on login
			if (! $this->session->userdata('user_session_id'))
			{
				//Generate a session ID that sticks with the cookie (session ids changes every 5 mins)
				$this->session->set_userdata('user_session_id', uniqid());
			}
			
			$email = ($this->session->userdata('email') !== FALSE) ? $this->session->userdata('email') : FALSE;
			$password = ($this->session->userdata('password') !== FALSE) ? $this->session->userdata('password') : FALSE;
			
			if ($email && $password)
			{
				//Try to get user data based on the email (normal login)
				$user_data = $this->User->get('email', $email);
				
				if ($user_data['password'] !== $password)
				{
					//User exists but the password didn't match
					return FALSE;
				}
				
				//Set the user_session_id to the logged in users ID, to avoid being classified as a temp user
				//Did cause problems with the sessions, not sure if I need this anymore or not
				//$this->session->set_userdata('user_session_id', $user_data['id']);	
			}
			else
			{
				//Try to get temporary users data based on session ID
				$user_data = $this->User->get('id', $this->session->userdata('user_session_id'));
			}
		}
		else
		{
			//Get specific user based on their user ID
			
			//Try to get user data based on user ID
			$user_data = $this->User->get('id', $user_id);
		}
		
		if (! $user_data)
		{
			return FALSE;
		}
		
		$user_data['profile_picture'] = (file_exists(APPPATH . '../assets/images/profile_pictures/' . $user_data['id'] . '.jpg')) ? 'assets/images/profile_pictures/' . $user_data['id'] . '.jpg' : 'assets/images/profile_pictures/nopic.jpg';
		$user_data['profile_picture_thumbnail'] = (file_exists(APPPATH . '../assets/images/profile_pictures/' . $user_data['id'] . '_thumb.jpg')) ? 'assets/images/profile_pictures/' . $user_data['id'] . '_thumb.jpg' : 'assets/images/profile_pictures/nopic_thumb.jpg';
		$user_data['gender_long'] = ($user_data['gender'] == 'M') ? 'male' : 'female';
	
		//The user seems to exist, get more info from this user
		$game_data = $this->Game->get('user_id', $user_data['id']);
		$ship_data = ($game_data) ? $this->Ship->get($user_data['id']) : array();
		$crew_data = ($game_data) ? $this->Crew->get_brief($user_data['id']) : array();
		
		//Add some extra game variables, calculated of the other tables
		$game_data['character_avatar_path'] = 'assets/images/avatars/' . (($game_data['character_gender'] == 'M') ? 'male' : 'female') . '/avatar_' . $game_data['character_avatar'] . '.jpg';
		$game_data['character_avatar_thumb_path'] = 'assets/images/avatars/' . (($game_data['character_gender'] == 'M') ? 'male' : 'female') . '_thumb/avatar_' . $game_data['character_avatar'] . '.jpg';
		$game_data['character_gender_long'] = ($game_data['character_gender'] == 'M') ? 'male' : 'female';
		
		$town_info = $this->config->item('towns');
		$game_data['nation'] = $town_info[$game_data['town']]['nation'];
		$game_data['town_human'] = ucwords($game_data['town'] . ((substr($game_data['town'], -1) != 's') ? 's' : ''));

		$home_nation_info = $this->gamelib->get_nations($game_data['nationality']);
		$game_data['enemy'] = $home_nation_info['enemy'];
		$game_data['towns_enemy'] = $town_info[$game_data['town']]['enemy'];

		$game_data['ships'] = count($ship_data);
		$game_data['crew_members'] = $crew_data['num_crew'];
		$game_data['crew_health_lowest'] = ($crew_data['num_crew'] > 0) ? $crew_data['min_health'] : 100;
		$game_data['crew_lowest_mood'] = ($crew_data['num_crew'] > 0) ? $crew_data['min_mood'] : 10;
		$game_data['crew_lowest_friendly_mood'] = $this->gamelib->get_crew_friendly_mood($game_data['crew_lowest_mood']);
		$game_data['needed_food'] = floor(0.5 * $game_data['crew_members']);
		$game_data['needed_water'] = $game_data['crew_members'];

		$game_data['total_victories'] = $game_data['victories_england'] + $game_data['victories_france'] + $game_data['victories_spain'] + $game_data['victories_holland'] + $game_data['victories_pirates'];
		$game_data['level'] = $game_data['victories_' . $game_data['enemy']] - $game_data['victories_' . $game_data['nationality']];

		$game_data['manned_cannons'] = (($game_data['crew_members'] / 2) > $game_data['cannons']) ? $game_data['cannons'] : floor($game_data['crew_members'] / 2);
		$game_data['load_max'] = 0;
		$game_data['min_crew'] = 0;
		$game_data['max_crew'] = 0;
		$game_data['max_cannons'] = 0;
		$game_data['ship_health_lowest'] = 100;

		$ship_specs = $this->config->item('ship_types');

		foreach ($ship_data as $ship)
		{
			$game_data['load_max'] += $ship_specs[$ship['type']]['load_capacity'];
			$game_data['min_crew'] += $ship_specs[$ship['type']]['min_crew'];
			$game_data['max_crew'] += $ship_specs[$ship['type']]['max_crew'];
			$game_data['max_cannons'] += $ship_specs[$ship['type']]['max_cannons'];
			$game_data['ship_health_lowest'] = ($ship['health'] < $game_data['ship_health_lowest']) ? $ship['health'] : $game_data['ship_health_lowest'];
		}

		$game_data['load_current'] = $game_data['food'] + $game_data['water'] + $game_data['porcelain'] + $game_data['spices'] + $game_data['silk'] + $game_data['medicine'] + $game_data['tobacco'] + $game_data['rum'];
		$game_data['load_left'] = $game_data['load_max'] - $game_data['load_current'];

		return array('user' => $user_data, 'game' => $game_data, 'ship' => $ship_data, 'crew' => $crew_data);

	}
	
	function error_404()
	{
		$this->load->view_ajax('view_404');
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */