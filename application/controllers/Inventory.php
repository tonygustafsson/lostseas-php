<?php

include('Main.php');

class Inventory extends Main
{
    public function __construct()
    {
        //Checks if it's the current users inventory or someones elses.
        //If it's someone elses we get their data.
        parent::__construct();

        $this->player_id = $this->uri->segment(3);
        $this->url_page = $this->uri->segment(4);

        $this->data['player'] = ($this->player_id != "" && $this->player_id != $this->data['user']['id']) ? $this->get_user_data($this->player_id) : $this->data;

        if (! $this->data['player'] || ($this->player_id == "" && $this->uri->segment(2) != 'players')) {
            exit;
        }
    }
    
    public function players()
    {
        if ($this->data['user']['verified'] == 1) {
            $this->data['players'] = $this->User->get_players(array('verified_only' => true));
            
            if ($this->data['user']['admin'] == 1) {
                $this->data['temp_players'] = $this->User->get_players(array('temp_only' => true));
            }

            $this->load->view_ajax('inventory/view_players', $this->data);
        }
    }

    public function player()
    {
        //User info about a player
        if ($this->data['player']['user']['verified'] == 1) {
            $this->data['player']['user']['age'] = $this->calc_age($this->data['player']['user']['birthday']);
        }
        
        $this->data['player']['game']['character_description'] = nl2br($this->data['player']['game']['character_description']);
        $this->data['player']['game']['character_real_age'] = $this->data['player']['game']['character_age'] + floor($this->data['player']['game']['week'] / 52);
        
        $this->load->view_ajax('inventory/view_player', $this->data);
    }

    public function history()
    {
        if ($this->data['user']['id'] == $this->data['player']['user']['id'] || $this->data['player']['user']['show_history'] == 1) {
            $this->load->model('history');

            $this->data['history_weeks'] = array(5, 10, 20, 40, 60, 80, 100);
            $this->data['history_data'] = array('doubloons' => 'Doubloons', 'ships' => 'Ships', 'crew_members' => 'Crew members', 'crew_mood' => 'Crew mood', 'crew_health' => 'Crew health', 'cannons' => 'Cannons', 'stock_value' => 'Stock value', 'level' => 'Level', 'victories' => 'Victories');

            $this->data['data_type_suffix'] = array('doubloons' => 'dbl', 'ships' => 'ships', 'crew_members' => 'crew members', 'crew_mood' => 'mood / 40', 'crew_health' => '% health', 'cannons' => 'cannons', 'stock_value' => 'dbl', 'level' => '', 'victories' => 'victories');
            $this->data['data_type'] = 'doubloons';
            $this->data['data_title'] = 'Doubloons';
            
            if ($this->uri->segment(4) != "" && $this->uri->segment(5) != "") {
                $history_input['weeks'] = (is_numeric($this->uri->segment(5)) && $this->uri->segment(5) <= 100 && $this->uri->segment(5) > 0) ? $this->uri->segment(5) : 20;
                $this->data['data_type'] = (array_key_exists($this->uri->segment(4), $this->data['history_data'])) ? $this->uri->segment(4) : 'doubloons';
                $this->data['data_title'] = (array_key_exists($this->uri->segment(4), $this->data['history_data'])) ? $this->data['history_data'][$this->uri->segment(4)] : 'Doubloons';
            }
            
            $history_input['user_id'] = $this->data['player']['user']['id'];
            $history_data = $this->history->get($history_input);
            $this->data['history'] = $history_data;
            $chart_data = array();
            $chart_labels = array();
            
            if ($history_data) {
                foreach ($history_data as $index => $history) {
                    if ($index % 4) {
                        continue;
                    }

                    $chart_data[] = $history[$this->data['data_type']];
                    $chart_labels[] = 'W' . $history['week'];
                }
            }

            $chart_data = join(",", $chart_data);
            $chart_labels = join(",", $chart_labels);
                    
            $this->data['chart_data'] = $chart_data;
            $this->data['chart_labels'] = $chart_labels;
        }
    
        $this->load->view_ajax('inventory/view_history', $this->data);
    }

    public function crew()
    {
        $this->data['actions'] = array('medicine' => 'Give medicine (heal)', 'tobacco' => 'Give tobacco (+1 mood)', 'doubloons' => 'Give 100 dbl (+2 mood)', 'rum' => 'Give rum (+3 mood)', 'discard' => 'Discard crew members');
        $this->data['action'] = ($this->input->post('action') != "") ? $this->input->post('action') : false;
        $this->data['edited_crew'] = ($this->input->post('crew') != "") ? $this->input->post('crew') : false;
        
        $accepted_orders = array('name_asc', 'name_desc', 'health_asc', 'health_desc', 'nationality_asc', 'nationality_desc', 'created_asc', 'created_desc', 'doubloons_asc', 'doubloons_desc', 'mood_asc', 'mood_desc');

        if (in_array($this->uri->segment(4), $accepted_orders)) {
            list($order, $direction) = explode("_", $this->uri->segment(4));
            $this->data['player']['crew'] = $this->Crew->get(array('user_id' => $this->data['player']['user']['id'], 'order' => $order . ' ' . $direction));
        } else {
            $this->data['player']['crew'] = $this->Crew->get(array('user_id' => $this->data['player']['user']['id']));
        }
        
        $this->load->view_ajax('inventory/view_crew', $this->data);
    }
    
    public function crew_post()
    {
        if ($this->input->post('crew') != "" && $this->input->post('action') != "" && $this->data['user']['id'] === $this->data['player']['user']['id']) {
            //Edit your crew...
            $data['success'] = "";
            $data['changeElements'] = array();
            
            $edited_crew = $this->input->post('crew');
            $number_of_men = count($edited_crew);
            $action_array = $this->input->post('action');
            $action = $action_array[0];
            $affected_crew = array();
            
            $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
            
            if (isset($edited_crew[0])) {
                if ($action == 'discard') {
                    foreach ($edited_crew as $man_id) {
                        $crew_input['id'] = $man_id;
                        $crew_result = $this->Crew->erase($crew_input);
                        $data['changeElements']['crew_' . $man_id]['remove'] = true;
                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                    }

                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'death';
                    }
                    
                    $data['success'] .= 'You discarded ' . $number_of_men . ' of your crew.';
                    
                    $log_input['entry'] = 'discarded ' . $number_of_men . ' of the crew members.';
                    $this->Log->create($log_input);
                } elseif ($action == 'medicine') {
                    $number_of_healed_men = 0;
                    $number_of_ignored_men = 0;
                    
                    if ($number_of_men <= $this->data['game']['medicine']) {
                        foreach ($edited_crew as $man_id) {
                            if ($this->data['crew'][$man_id]['health'] < 100) {
                                $crew_updates[$man_id]['health'] = 100;
                                $data['changeElements']['crew_health_' . $man_id]['text'] = 100;
                                $number_of_healed_men++;
                            } else {
                                $number_of_ignored_men++;
                            }
                        }

                        if (isset($crew_updates)) {
                            $crew_result = $this->Crew->update($crew_updates);
                        }

                        if ($number_of_healed_men > 0) {
                            $updates['medicine']['sub'] = true;
                            $updates['medicine']['value'] = $number_of_healed_men;
                            $game_result = $this->Game->update($updates);
                            
                            $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                            
                            $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                            
                            $data['success'] .= $number_of_healed_men . ' of your crew members were healed with medicine.';
                            
                            if ($this->data['user']['sound_effects_play'] == 1) {
                                $data['playSound'] = 'mmm';
                            }
                            
                            $log_input['entry'] = 'healed ' . $number_of_healed_men . ' crew members with medicine.';
                            $this->Log->create($log_input);
                        }
                        
                        if ($number_of_ignored_men > 0) {
                            $data['success'] .= ' ' . $number_of_ignored_men . ' of your crew members did not need medicine so they gave it back.';
                        }
                    } else {
                        $data['error'] = 'You don\'t have enough medicine boxes to do that!';
                    }
                } elseif ($action == 'tobacco') {
                    if ($number_of_men <= $this->data['game']['tobacco']) {
                        foreach ($edited_crew as $man_id) {
                            $crew_updates[$man_id]['mood'] = "+1";
                            $data['changeElements']['crew_mood_' . $man_id]['text'] = $this->data['crew'][$man_id]['mood'] + 1;
                        }
                        
                        $crew_result = $this->Crew->update($crew_updates);

                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                                
                        $data['success'] = 'You gave ' . $number_of_men . ' of your crew tobacco which increased their mood by 1.';
                        
                        $updates['tobacco']['sub'] = true;
                        $updates['tobacco']['value'] = $number_of_men;
                        $game_result = $this->Game->update($updates);
                        
                        if ($this->data['user']['sound_effects_play'] == 1) {
                            $data['playSound'] = 'mmm';
                        }
                        
                        $log_input['entry'] = 'gave ' . $number_of_men . ' of the crew members tobacco which increased their mood by 1.';
                        $this->Log->create($log_input);
                        
                        $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                    } else {
                        $data['error'] = 'You do not have enough tobacco!';
                    }
                } elseif ($action == 'doubloons') {
                    if (($number_of_men * 100) <= $this->data['game']['doubloons']) {
                        foreach ($edited_crew as $man_id) {
                            $crew_updates[$man_id]['mood'] = "+2";
                            $crew_updates[$man_id]['doubloons'] = "+100";
                            $data['changeElements']['crew_mood_' . $man_id]['text'] = $this->data['crew'][$man_id]['mood'] + 2;
                            $data['changeElements']['crew_doubloons_' . $man_id]['text'] = $this->data['crew'][$man_id]['doubloons'] + 100;
                        }
                        
                        $crew_result = $this->Crew->update($crew_updates);

                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                                
                        $data['success'] = 'You gave ' . $number_of_men . ' of the crew members 100 dbl which, increased their mood by 2.';
                        
                        $updates['doubloons']['sub'] = true;
                        $updates['doubloons']['value'] = ($number_of_men * 100);
                        $game_result = $this->Game->update($updates);
                        
                        if ($this->data['user']['sound_effects_play'] == 1) {
                            $data['playSound'] = 'coins';
                        }
                        
                        $log_input['entry'] = 'gave ' . $number_of_men . ' of the crew members 100 dbl, which increased their mood by 2.';
                        $this->Log->create($log_input);
                        
                        $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                    } else {
                        $data['error'] = 'You do not have ' . ($number_of_men * 100) . ' doubloons!';
                    }
                } elseif ($action == 'rum') {
                    if ($number_of_men <= $this->data['game']['rum']) {
                        foreach ($edited_crew as $man_id) {
                            $crew_updates[$man_id]['mood'] = "+3";
                            $data['changeElements']['crew_mood_' . $man_id]['text'] = $this->data['crew'][$man_id]['mood'] + 3;
                        }
                        
                        $crew_result = $this->Crew->update($crew_updates);

                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                                
                        $data['success'] = 'You gave ' . $number_of_men . ' of your crew rum which increased their mood by 3.';
                        
                        $updates['rum']['sub'] = true;
                        $updates['rum']['value'] = $number_of_men;
                        $result = $this->Game->update($updates);
                        
                        if ($this->data['user']['sound_effects_play'] == 1) {
                            $data['playSound'] = 'mmm';
                        }
                        
                        $log_input['entry'] = 'gave ' . $number_of_men . ' of the crew members rum which increased their mood by 3.';
                        $this->Log->create($log_input);
                        
                        $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                    } else {
                        $data['error'] = 'You do not have enough rum!';
                    }
                }
            }
        } else {
            $data['info'] = 'No changes made...';
        }
        
        echo json_encode($data);
    }

    public function ships()
    {
        $this->data['player']['ship'] = $this->Ship->get($this->data['player']['user']['id']);
        $this->data['ship_specs'] = $this->config->item('ship_types');

        $this->load->view_ajax('inventory/view_ships', $this->data);
    }

    public function log()
    {
        $get_entry_first = ($this->url_page != "") ? $this->url_page : 0;
        $get_entry_last = 50;

        $log_input['user_id'] = $this->data['player']['user']['id'];
        $log_input['first_entry'] = $get_entry_first;
        $log_input['entries'] = $get_entry_last;
        $log_input['privacy_ignored'] = ($this->data['player']['user']['id'] === $this->data['user']['id']) ? true : false;
        $this->data['player']['log'] = $this->Log->get($log_input);
        
        //Set up pagination
        $this->load->library('pagination');
        $config['uri_segment'] = 4;
        $config['base_url'] = base_url('inventory/log/' . $this->data['player']['user']['id']);
        $config['total_rows'] = $this->data['player']['log']['num_rows'];
        $config['per_page'] = 50;
        $config['num_links'] = 14;
        $config['attributes'] = array('class' => 'ajaxHTML');
        $this->pagination->initialize($config);

        //Unset this to now make it show up in the log results
        unset($this->data['player']['log']['num_rows']);
        
        $this->data['pages'] = $this->pagination->create_links();
        
        $this->load->view_ajax('inventory/view_log', $this->data);
    }
    
    public function user_remove()
    {
        if ($this->uri->segment(4) != "" && $this->data['user']['admin'] == 1) {
            $id = $this->uri->segment(4);
            $this->User->erase($id);
            
            $data['changeElements']['player-' . $id]['remove'] = true;
            $data['success'] = "Player was deleted.";
            
            echo json_encode($data);
        }
    }

    public function calc_age($birthday)
    {
        list($birthday, $time) = explode(" ", $birthday);
        list($year, $month, $day) = explode("-", $birthday);

        $year_diff  = date("Y") - $year;
        $month_diff = date("m") - $month;
        $day_diff   = date("d") - $day;

        if ($month_diff < 0) {
            $year_diff--;
        } elseif ($month_diff == 0 && $day_diff < 0) {
            $year_diff--;
        }

        return $year_diff;
    }
}

/*  End of inventory.php */
/* Location: ./application/controllers/inventory.php */
