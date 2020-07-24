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
}
