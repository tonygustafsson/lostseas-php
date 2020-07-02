<?php

class Game extends CI_Model
{
    public function get($index, $value, $filter = false)
    {
        if ($filter) {
            //use $filter as 'password' or 'password, username, phone' to get more than one
            $this->db->select($filter);
        }
        
        $this->db->where($index, $value);
        $game_data = $this->db->get($this->db->game_table);
        $game_data = ($game_data->num_rows() > 0) ? $game_data->row_array() : false;
        
        return $game_data;
    }

    public function create($input)
    {
        //Register game data on registration
        $this->db->insert($this->db->game_table, $input);
        
        $output['success'] = true;
        
        return $output;
    }
    
    public function update($updates)
    {
        //Updating game database
        $sql_updates = array();
        $output['changeElements'] = array();
        $updates['user_id'] = (isset($updates['user_id'])) ? $updates['user_id'] : $this->data['user']['id'];
        
        if (isset($updates['user_id'])) {
            $standard = array('character_name', 'character_gender', 'character_age', 'character_description',
                              'nationality', 'title', 'doubloons', 'food', 'water', 'porcelain', 'spices', 'silk',
                              'tobacco', 'rum', 'medicine', 'rafts', 'bank_account', 'bank_loan', 'prisoners',
                              'victories_england', 'victories_france', 'victories_spain', 'victories_holland', 'victories_pirates',
                              'event_market_goods', 'event_market_slaves', 'event_sailors', 'event_work', 'event_ship',
                              'event_ship_won', 'event_ocean_trade', 'event_tavern_blackjack');
            
            $inventory_items = array('doubloons', 'food', 'water', 'porcelain', 'spices', 'silk', 'title', 'nationality',
                                     'tobacco', 'rum', 'medicine', 'rafts', 'bank_account', 'bank_loan', 'prisoners', 'character_name');
            
            foreach ($standard as $item) {
                if (isset($updates[$item])) {
                    $value = (isset($updates[$item]['value'])) ? $this->_calc_value($updates[$item], $this->data['game'][$item], 0) : $updates[$item];

                    $sql_updates[$item] = $value;
                    
                    $output[$item]['success'] = $value;
                    
                    if (in_array($item, $inventory_items)) {
                        $output['changeElements']['inventory_' . $item]['text'] = $value;
                    }
                }
            }
            
            if (isset($updates['character_avatar'])) {
                $item = 'character_avatar';
            
                $value = (isset($updates[$item]['value'])) ? $this->_calc_value($updates[$item], $this->data['game'][$item], 0) : $updates[$item];
            
                list($gender, $avatar) = explode("###", $value);
            
                $sql_updates[$item] = $avatar;
                
                $output[$item]['success'] = $value;
                
                $image_path = APPPATH . '../assets/images/avatars/' . $gender . '/avatar_' . $avatar . '.png';
                $output['changeElements']['inventory_' . $item]['src'] = $image_path;
            }
            
            if (isset($updates['week'])) {
                $item = 'week';
            
                $value = (isset($updates[$item]['value'])) ? $this->_calc_value($updates[$item], $this->data['game'][$item], 0) : $updates[$item];
                
                $sql_updates[$item] = $value;
                
                $output[$item]['success'] = $value;
                $output['changeElements']['inventory_' . $item]['text'] = $value;
                
                //Write to the history database for graphs and such
                $this->load->model('history');
                $this->history->create();
            }
            
            if (isset($updates['cannons'])) {
                $item = 'cannons';
            
                $value = (isset($updates[$item]['value'])) ? $this->_calc_value($updates[$item], $this->data['game'][$item], 0) : $updates[$item];
                
                $sql_updates[$item] = $value;
                
                $output[$item]['success'] = $value;
                $output['changeElements']['inventory_' . $item]['text'] = $value;
                
                $manned_cannons = (floor($this->data['game']['crew_members'] / 2) > $value) ? $value : floor($this->data['game']['crew_members'] / 2);
                $output['changeElements']['inventory_manned_cannons']['text'] = $manned_cannons;
                $output['changeElements']['inventory_cannons_link']['title'] = 'You own ' . $value . ' cannons, ' . $manned_cannons . ' are manned';
            }
            
            if (isset($updates['town'])) {
                $item = 'town';
                $accepted_towns = array_keys($this->config->item('towns'));

                if (in_array($updates['town'], $accepted_towns)) {
                    $sql_updates[$item] = $updates['town'];
                    $output['town']['success'] = $updates['town'];
                } else {
                    $output['error'] = 'This town does not exist!';
                }
            }
            
            if (isset($updates['place'])) {
                $item = 'place';
            
                $town_places = array('shop', 'tavern', 'bank', 'market', 'dock', 'cityhall', 'shipyard');
                $town_places_goto = array('shop', 'tavern', 'bank', 'market', 'dock', 'cityhall', 'shipyard', 'harbor');
                $harbor_places_goto = array('shop', 'tavern', 'bank', 'market', 'dock', 'cityhall', 'shipyard', 'harbor');
                $ocean_places_goto = array('ocean', 'harbor');

                if ((in_array($this->data['game']['place'], $town_places) && in_array($updates['place'], $town_places_goto)) || ($this->data['game']['place'] == 'harbor' && in_array($updates['place'], $harbor_places_goto)) || ($this->data['game']['place'] == 'ocean' && in_array($updates['place'], $ocean_places_goto))) {
                    $sql_updates[$item] = $updates['place'];
                    $output['place']['success'] = $updates['place'];
                } else {
                    $output['error'] = 'This place does not exist!';
                }
            }
            
            if (count($sql_updates) > 0) {
                $sql = $this->_update_query_builder($sql_updates, $updates['user_id']);
                $this->db->query($sql);
            } else {
                $output['error'] = 'No changes made.';
            }
            
            return $output;
        }
    }
    
    public function _calc_value($update, $current, $min = false, $max = false)
    {
        if (isset($update['add'])) {
            $output = $current + $update['value'];
            $output = ($max && $output > $max) ? $max : $output;
        } elseif (isset($update['sub'])) {
            $output = $current - $update['value'];
            $output = ($min && $output < $min) ? $min : $output;
        } else {
            $output = $update['value'];
            $output = ($max && $output > $max) ? $max : $output;
            $output = ($min && $output < $min) ? $min : $output;
        }
        
        return $output;
    }
    
    public function _update_query_builder($updates, $user_id)
    {
        $sql = 'UPDATE ' . $this->db->game_table . ' SET ';
        
        $updates_keys = array_keys($updates);
        $updates_values = array_values($updates);
        
        for ($x = 0; $x < count($updates); $x++) {
            $key = $updates_keys[$x];
            $val = (is_numeric($updates_values[$x])) ? $updates_values[$x] : "'" . $this->db->escape_str($updates_values[$x]) . "'";
            
            $sql .= $key . ' = ' . $val;
            
            if ($x < (count($updates) - 1)) {
                $sql .= ',';
            }
        }
        
        $sql .= ' WHERE user_id = "' . $user_id . '"';
        
        return $sql;
    }
}

/* End of file game.php */
/* Location: ./application/models/game.php */
