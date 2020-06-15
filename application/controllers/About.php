<?php

include('Main.php');

class About extends Main
{
    public function index()
    {
        $this->data['logged_in'] = (isset($this->data['user'])) ? true : false;
        $this->data['character'] = $this->gamelib->generate_character();
        
        $this->data['meta_description'] = "What is needed in the game, like food and water. Also about the trading goods.";
        $this->data['meta_keywords'] = "lost seas, trading goods, supplies, food, water, tobacco, rum, medicine, spices, porcelain";
        
        if ($this->data['logged_in'] === false) {
            $log_input['entries'] = 8;
            $log_input['get_num_rows'] = false;
            $this->data['log_entries'] = $this->Log->get($log_input);
        }
        
        $this->load->view_ajax('about/view_guide', $this->data);
    }

    public function presentation()
    {
        $this->data['logged_in'] = (isset($this->data['user'])) ? true : false;
        $this->data['character'] = $this->gamelib->generate_character();
            
        if ($this->data['logged_in'] === false) {
            $log_input['entries'] = 8;
            $log_input['get_num_rows'] = false;
            $this->data['log_entries'] = $this->Log->get($log_input);
        }
        
        $this->load->view_ajax('about/view_presentation', $this->data);
    }

    public function news()
    {
        $this->load->model('News');
        $this->load->library('pagination');
        
        $this->data['meta_description'] = "What is new in Lost Seas? Read about the latest updates!";
        $this->data['meta_keywords'] = "lost seas, news, updates, what's new, rss";

        //Get the news data
        $first_entry = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $entries_per_page = 10;
        $this->data['news'] = $this->News->get('list', $first_entry, $entries_per_page);

        //Prepare the pagination
        $pagination_config['uri_segment'] = 3;
        $pagination_config['base_url'] = base_url('about/news/');
        $pagination_config['total_rows'] = $this->data['news']['num_rows'];
        $pagination_config['per_page'] = $entries_per_page;
        $pagination_config['num_links'] = 5;
        $pagination_config['attributes'] = array('class' => 'ajaxHTML');
        $this->pagination->initialize($pagination_config);
        $this->data['pages'] = $this->pagination->create_links();

        //Unset this value so that the view doesn't try to render it as a news entry
        unset($this->data['news']['num_rows']);

        $this->data['logged_in'] = (isset($this->data['user'])) ? true : false;
        $this->data['character'] = $this->gamelib->generate_character();
                
        if ($this->data['logged_in'] === false) {
            $log_input['entries'] = 8;
            $log_input['get_num_rows'] = false;
            $this->data['log_entries'] = $this->Log->get($log_input);
        }
        
        $this->load->view_ajax('about/view_news', $this->data);
    }

    public function news_post()
    {
        $existing_news_id = $this->input->post('news_id');

        if (!$existing_news_id) {
            if ($this->data['user']['admin'] == 1) {
                $form_rules['time']		= array('name' => 'Time', 'date' => true);
                $form_rules['news_entry']	= array('name' => 'The news', 'min_length' => 10);
            
                $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
                if (! $data['error']) {
                    $this->load->model('News');
                
                    $news['time'] = $this->input->post('time');
                    $news['entry'] = $this->input->post('news_entry');
                    $new_news = $this->News->create($news);
                
                    $data['changeElements']['news_entries']['prepend'] = $new_news;

                    $data['success'] = 'Successfully created news!';
                }
            
                echo json_encode($data);
            }
        } else {
            // Editing existing news post
            if ($this->data['user']['admin'] == 1) {
                $form_rules['news_id']		= array('name' => 'News ID', 'numeric' => true);
                $form_rules['time']			= array('name' => 'Time', 'date' => true);
                $form_rules['news_entry']	= array('name' => 'The news', 'min_length' => 10);
                
                $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
                
                if (! $data['error']) {
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
                    
                    foreach ($rows as $row) {
                        $new_html .= '<li>' . $row . '</li>';
                    }
    
                    $new_html .= '
                        </ul>
                    ';
    
                    $data['success'] = 'Successfully edited news entry!';
                    $data['changeElements']['entry-' . $id]['html'] = $new_html;
                }
                
                echo json_encode($data);
            }
        }
    }
    
    public function edit_news()
    {
        if ($this->data['user']['admin'] == 1) {
            $this->load->model('News');

            $id = $this->uri->segment(3);
            $this_entry = $this->News->get($id);
              
            $data['changeElements']['news_form_post_id']['val'] = $this_entry['id'];
            $data['changeElements']['news_form_entry']['val'] = $this_entry['entry'];
            $data['changeElements']['news_form_time']['val'] = date("Y-m-d", $this_entry['unix_time']);
            $data['changeElements']['news_form_legend']['text'] = 'Edit news post';

            echo json_encode($data);
        }
    }
   
    public function erase_news()
    {
        if ($this->data['user']['admin'] == 1 && $this->uri->segment(3) != '') {
            $this->load->model('News');

            $id = $this->uri->segment(3);
            $this->News->erase($id);
            
            $data['changeElements']['entry-' . $id]['remove'] = true;
            $data['success'] = 'Successfully removed news ID' . $id . '.';
            
            echo json_encode($data);
        }
    }

    public function copyright()
    {
        $this->data['logged_in'] = (isset($this->data['user'])) ? true : false;
        $this->data['character'] = $this->gamelib->generate_character();
        
        $this->data['meta_description'] = "About the copyright of this game.";
        $this->data['meta_keywords'] = "lost seas, copyright, owner, creator";
        
        if ($this->data['logged_in'] === false) {
            $log_input['entries'] = 8;
            $log_input['get_num_rows'] = false;
            $this->data['log_entries'] = $this->Log->get($log_input);
        }
        
        $this->load->view_ajax('about/view_copyright', $this->data);
    }
}

/*  End of about.php */
/* Location: ./application/controllers/about.php */
