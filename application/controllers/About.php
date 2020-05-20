<?PHP

include('Main.php');

class About extends Main {

	function index()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;

		$this->guide_supplies();
	}

	function presentation()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
			
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_presentation', $this->user);
	}

	function news()
	{
		$this->load->model('News');
		$this->load->library('pagination');
		
		$this->user['meta_description'] = "What is new in Lost Seas? Read about the latest updates!";
		$this->user['meta_keywords'] = "lost seas, news, updates, what's new, rss";

		//Get the news data
		$first_entry = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$entries_per_page = 10;
		$this->user['news'] = $this->News->get('list', $first_entry, $entries_per_page);

		//Prepare the pagination
		$pagination_config['uri_segment'] = 3;
		$pagination_config['base_url'] = base_url('about/news/');
		$pagination_config['total_rows'] = $this->user['news']['num_rows'];
		$pagination_config['per_page'] = $entries_per_page;
		$pagination_config['num_links'] = 5;
		$pagination_config['attributes'] = array('class' => 'ajaxHTML');
		$this->pagination->initialize($pagination_config);
		$this->user['pages'] = $this->pagination->create_links();

		//Unset this value so that the view doesn't try to render it as a news entry
		unset($this->user['news']['num_rows']);

		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
				
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_news', $this->user);
	}

	function news_post()
	{
		if ($this->user['user']['admin'] == 1)
		{
			$form_rules['time']		= array('name' => 'Time', 'date' => TRUE);
			$form_rules['news_entry']	= array('name' => 'The news', 'min_length' => 10);
			
			$data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
			
			if (! $data['error'])
			{
				$this->load->model('News');
				
				$news['time'] = $this->input->post('time');
				$news['entry'] = $this->input->post('news_entry');
				$new_news = $this->News->create($news);
				
				$data['changeElements']['news_entries']['prepend'] = $new_news;
				$data['runJS'] = '$("#news_form")[0].reset();';

				$data['success'] = 'Successfully created news!';
			}
			
			echo json_encode($data);
		}
	}
	
	function edit_news()
	{
		if ($this->user['user']['admin'] == 1)
		{
			$this->load->model('News');

			$id = $this->uri->segment(3);
			$this_entry = $this->News->get($id);
		
			$new_form = '
				<form method="post" class="ajaxJSON" action="' . base_url('about/edit_news_post') . '">
					<fieldset>
						<legend>Edit news</legend>
						<input type="hidden" name="news_id" value="' . $this_entry['id'] . '">
						
						<label for="time">Time</label>
						<input type="text" name="time" value="' . date("Y-m-d", $this_entry['unix_time']) . '">
						
						<label for="news_entry">The news</label>
						<textarea name="news_entry">' . $this_entry['entry'] . '</textarea>
						
						<input type="submit" value="Edit">
					</fieldset>
				</form>
			';
			
			$data['changeElements']['news_form_section']['html'] = $new_form;
		
			echo json_encode($data);
		}
	}

	function edit_news_post()
	{
		if ($this->user['user']['admin'] == 1)
		{
			$form_rules['news_id']		= array('name' => 'News ID', 'numeric' => TRUE);
			$form_rules['time']			= array('name' => 'Time', 'date' => TRUE);
			$form_rules['news_entry']	= array('name' => 'The news', 'min_length' => 10);
			
			$data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
			
			if (! $data['error'])
			{		
				$this->load->model('News');

				$id = $this->input->post('news_id');
				$changes['time'] = $this->input->post('time');
				$changes['entry'] = $this->input->post('news_entry');
				$this->News->update($id, $changes);
				$rows = explode("\n\n", $this->input->post('news_entry'));
				
				$new_html = '
					<h3>' . date("jS F, Y", strtotime($this->input->post('time'))) . '</h3>
					<ul>
				';
				
				foreach ($rows as $row)
				{
					$new_html .= '<li>' . $row . '</li>';
				}

				$new_html .= '
					</ul>
					
					<p style="padding-left: 1em;">
						<a class="ajaxJSON" href="' . base_url('about/edit_news/' . $id) . '"><img src="' . base_url('assets/images/icons/edit.png') . '" width="16"></a>
						<a class="ajaxJSON" rel="Are you sure you want to delete this?" href="' . base_url('about/erase_news/' . $id) . '"><img src="' . base_url('assets/images/icons/erase.png') . '" width="16"></a>
					</p>
				';

				$data['success'] = 'Successfully edited news entry!';
				$data['changeElements']['entry-' . $id]['html'] = $new_html;
			}
			
			echo json_encode($data);
		}
	}
	
	function erase_news()
	{
		if ($this->user['user']['admin'] == 1 && $this->uri->segment(3) != '')
		{
			$this->load->model('News');

			$id = $this->uri->segment(3);
			$this->News->erase($id);
			
			$data['changeElements']['entry-' . $id]['remove'] = TRUE;
			$data['success'] = 'Successfully removed news ID' . $id . '.';
			
			echo json_encode($data);
		}
	}
	
	function news_feed()
	{
		$this->load->helper('xml');

		$data['encoding'] = 'utf-8';
		$data['feed_name'] = $this->config->item('site_name');
		$data['feed_url'] = base_url();
		$data['page_description'] = 'The web based adventure game with a piraty spirit!';
		$data['page_language'] = 'en-us';
		$data['creator_email'] = $this->config->item('email');

		$this->load->model('News');
		$data['posts'] = $this->News->get('rss');

		header("Content-Type: application/rss+xml");
		$this->load->view('about/view_news_rss', $data);
	}

	function guide_supplies()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "What is needed in the game, like food and water. Also about the trading goods.";
		$this->user['meta_keywords'] = "lost seas, trading goods, supplies, food, water, tobacco, rum, medicine, spices, porcelain";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_supplies', $this->user);
	}

	function guide_ships()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "About the different kind of ships in the game, and about the usage of cannons and rafts.";
		$this->user['meta_keywords'] = "lost seas, ships, brigs, galleons, frigates, merchantmans, cannons, rafts";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_ships', $this->user);
	}

	function guide_crew()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "About your crew members. How to get them, how to please them.";
		$this->user['meta_keywords'] = "lost seas, crew members, crew, staff";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_crew', $this->user);
	}

	function guide_titles()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "It's all about titles in Lost Seas! How to become different titles, and their rewards.";
		$this->user['meta_keywords'] = "lost seas, titles, levels, rewards, nations";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_titles', $this->user);
	}

	function guide_economy()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "How to get more money in this game, and about saving your doubloons.";
		$this->user['meta_keywords'] = "lost seas, money, doubloons, bank, cash, loans";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_economy', $this->user);
	}

	function guide_traveling()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "About traveling in this piratey game. From town to town in different ships, fighting enemies.";
		$this->user['meta_keywords'] = "lost seas, travel, sea, ocean, attack, flee, fight, ships";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_traveling', $this->user);
	}

	function guide_players()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "How to interact with other players, and follow their progress.";
		$this->user['meta_keywords'] = "lost seas, players, interact, chatting, messaging";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_players', $this->user);
	}

	function guide_settings()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "How to change your settings in this game, like password or email address.";
		$this->user['meta_keywords'] = "lost seas, settings, email address, unsubscribe, password";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_guide_settings', $this->user);
	}

	function ideas()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "The future plans for this game. A todo list of features that we would like to see. You can also add requests.";
		$this->user['meta_keywords'] = "lost seas, ideas, requests, game, features, future";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_ideas', $this->user);
	}

	function tech()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();
		
		$this->user['meta_description'] = "About the technologies for creating this game, like CodeIgniter, HTML5, jQuery and CSS3.";
		$this->user['meta_keywords'] = "lost seas, tech, technlogogies, html5, jquery, css3, web, ajax";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_tech', $this->user);
	}

	function copyright()
	{
		$this->user['logged_in'] = (isset($this->user['user'])) ? TRUE : FALSE;
		$this->user['character'] = $this->gamelib->generate_character();	
		
		$this->user['meta_description'] = "About the copyright of this game.";
		$this->user['meta_keywords'] = "lost seas, copyright, owner, creator";
		
		if ($this->user['logged_in'] === FALSE)
		{
			$log_input['entries'] = 8;
			$log_input['get_num_rows'] = FALSE;
			$this->user['log_entries'] = $this->Log->get($log_input);
		}
		
		$this->load->view_ajax('about/view_copyright', $this->user);
	}
	
	function send_suggestion()
	{
		//Validate form data
		$form_rules['email'] 				= array('name' => 'Email address', 'email' => TRUE);
		$form_rules['your_name'] 			= array('name' => 'Name', 'min_length' => 3);
		$form_rules['suggestion'] 			= array('name' => 'Suggestion', 'min_length' => 10);
		
		$data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
		
		if ($this->input->post('name') != "")
		{
			//Honeypot, probably a bot...
			exit();
		}

		//Check if the inputs are OK
		if (! $data['error'])
		{
			$this->load->library('email');
			$this->email->from($this->input->post('email'), $this->input->post('your_name'));
			$this->email->reply_to($this->input->post('email'), $this->input->post('your_name'));
			$this->email->to($this->config->item('email'));
			$this->email->subject('A suggestion has been posted!');

			$message = "This suggestion is from " . $this->input->post('your_name') . " (" . $this->input->post('email') . "):\n\n";
			$message .= $this->input->post('suggestion');
			$this->email->message($message);
			$this->email->send();

			$data['success'] = 'Your suggestion has been emailed successfully.';
		}
		
		echo json_encode($data);
	}

}

/*  End of about.php */
/* Location: ./application/controllers/about.php */