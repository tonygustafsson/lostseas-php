<?php

include('Main.php');

class Harbor extends Main
{
    public function index()
    {
        $this->this_place = 'harbor';

        if ($this->data['game']['place'] == 'ocean') {
            $data['changeElements'] = array();
        
            //From the ocean to a harbor
            $allowed_towns = array('charles towne', 'biloxi', 'havana', 'villa hermosa', 'belize', 'port royale', 'tortuga', 'leogane', 'san juan', 'st. martin', 'st. eustatius', 'martinique', 'barbados', 'panama', 'curacao', 'bonaire');
            $wanted_town = ($this->uri->segment(2) != "") ? str_replace("_", " ", $this->uri->segment(2)) : false;
            
            if (isset($wanted_town) && in_array($wanted_town, $allowed_towns)) {
                //Check if the town is OK to visit...
                $updates['town'] = $wanted_town;
                $updates['week']['add'] = true;
                $updates['week']['value'] = 1;
                $this->data['game']['town_human'] = ucwords($wanted_town . ((substr($wanted_town, -1) != 's') ? 's' : ''));

                $new_town = $this->config->item('towns');
                $this->data['game']['nation'] = $new_town[$wanted_town]['nation'];
                $this->data['game']['place'] = $updates['place'] = $this->this_place;

                $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
                $new_mood = $this->data['game']['crew_lowest_mood'] - 1;
                $crew_updates['all']['mood'] = $new_mood;
                $crew_output = $this->Crew->update($crew_updates);
                
                if ($crew_output['success']) {
                    $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
                }

                if (rand(1, 2) == 1 && empty($this->data['game']['event_ship']) && empty($this->data['game']['event_ocean_trade']) && $this->data['game']['ships'] > 0) {
                    //Meet a ship!
                    $ship_meeting = $this->gamelib->ship_spec($this->data['game']['manned_cannons'], $this->data['game']['nation']);
                    $ship_meeting['prisoners'] = ($ship_meeting['nation'] == $this->data['game']['enemy'] || $ship_meeting['nation'] == 'pirate') ? floor(rand(0, 2) * rand(0, 1)) : 0;
                    $this->data['game']['event_ship'] = $updates['event_ship'] = $ship_meeting['nation'] . '###' . $ship_meeting['type'] . '###' . $ship_meeting['crew'] . '###' . $ship_meeting['cannons'] . '###' . $ship_meeting['prisoners'];

                    $data['changeElements']['nav_ocean']['visibility'] = 'none';
                    $data['changeElements']['nav_harbor']['visibility'] = 'none';
                    $data['changeElements']['nav_dock']['visibility'] = 'none';

                    $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = ($ship_meeting['nation'] == 'pirate' || $ship_meeting['nation'] == $this->data['game']['enemy']) ? 'block' : 'none';
                    $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = ($ship_meeting['nation'] == $this->data['game']['nationality']) ? 'block' : 'none';
                    $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = ($ship_meeting['nation'] != 'pirate' && $ship_meeting['nation'] != $this->data['game']['nationality'] && $ship_meeting['nation'] != $this->data['game']['enemy']) ? 'block' : 'none';

                    $data['pushState'] = base_url('ocean/ship_meeting');
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'sailho';
                    }
                } else {
                    $data['changeElements']['nav_ocean']['visibility'] = 'none';
                    $data['changeElements']['nav_harbor']['visibility'] = 'block';
                    $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
                    $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
                    $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'landho';
                    }
                }
                
                $this->data['json'] = json_encode($data);

                $result = $this->Game->update($updates);
                
                $log_input['entry'] = 'traveled to ' . ucwords($wanted_town) . '.';
                $this->Log->create($log_input);
                
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);

                $view = (! empty($this->data['game']['event_ship']) || ! empty($this->data['game']['event_ocean_trade'])) ? 'ocean/view_ship_meeting' : $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
                $this->load->view_ajax($view, $this->data);
            }
        } else {
            //Going to the harbor from the town or page reload
            $town_to_harbor_access = true;
            $data['changeElements'] = array();
            
            if ($this->input->is_ajax_request()) {
                $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
                $this->data['game']['angry_crew'] = $this->gamelib->report_crew_unhappiness($this->data['crew']);
                $town_to_harbor_access = $this->check_access();
                
                if ($town_to_harbor_access === true) {
                    $data['changeElements']['nav_dock']['visibility'] = 'none';
                    $data['changeElements']['nav_harbor']['visibility'] = 'block';
                    $this->data['game']['place'] = $updates['place'] = $this->this_place;
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'wind';
                    }
                } else {
                    $data['error'] = 'You cannot leave just yet...';
                    $this->data['game']['warnings'] = $town_to_harbor_access;
                    $data['pushState'] = base_url('dock');
                    $this->data['game']['place'] = $updates['place'] = 'dock';
                }
                
                $result = $this->Game->update($updates);
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                
                $this->data['json'] = json_encode($data);
            }
            
            $view = ($town_to_harbor_access === true) ? $this->data['game']['place'] . '/view_' . $this->data['game']['place'] : 'dock/view_dock';
            $this->load->view_ajax($view, $this->data);
        }
    }

    public function check_access()
    {
        $warnings = array();
    
        if ($this->data['game']['angry_crew'] > 0) {
            $warnings[]['mood-aggressive'] = $this->data['game']['angry_crew'] . ' of your crew members are angry and do not want to leave town! You should please them or discard them.';
        }
        
        if ($this->data['game']['crew_members'] < $this->data['game']['min_crew']) {
            $warnings[]['crew-man'] = 'You need at least ' . $this->data['game']['min_crew'] . ' crew members to sail out. Get more men or sell a ship.';
        }
        
        if ($this->data['game']['crew_members'] > $this->data['game']['max_crew']) {
            $warnings[]['crew-man'] = 'Your ship only supports ' . $this->data['game']['max_crew'] . ' crew members at this time. Discard crew members or buy more ships.';
        }
        
        if ($this->data['game']['ships'] < 1) {
            $warnings[]['ship'] = 'You don\'t own a ship. You should buy one. Take a loan if you cannot afford it.';
        }
        
        if ($this->data['game']['load_left'] < 0) {
            $warnings[]['ship'] = 'Your ship can only carry ' . $this->data['game']['load_max'] . ' cartons, and you carry ' . $this->data['game']['load_current'] . '.';
        }
        
        if ($this->data['game']['cannons'] > $this->data['game']['max_cannons']) {
            $warnings[]['cannon'] = 'You cannot load more than ' . $this->data['game']['max_cannons']. ' cannons! Sell some cannons or buy new ships.';
        }
        
        if ($this->data['game']['food'] < $this->data['game']['needed_food']) {
            $warnings[]['food'] = 'You need at least ' . $this->data['game']['needed_food'] . ' cartons of food, or you will starve out there.';
        }
        
        if ($this->data['game']['water'] < $this->data['game']['needed_water']) {
            $warnings[]['water'] = 'You need at least ' . $this->data['game']['needed_water'] . ' barrels of water, or you will thirst do death out there.';
        }
        
        if (count($warnings) > 0) {
            return $warnings;
        } else {
            return true;
        }
    }
}

/*  End of harbor.php */
/* Location: ./application/controllers/harbor.php */
