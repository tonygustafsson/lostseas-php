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
        // Register game data on registration
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
            $standard = array(
                              'character_name', 'character_gender', 'character_avatar', 'character_age', 'character_description',
                              'nationality', 'title', 'doubloons', 'food', 'water', 'porcelain', 'spices', 'silk',
                              'tobacco', 'rum', 'medicine', 'rafts', 'bank_account', 'bank_loan', 'prisoners'
                            );
            
            $inventory_items = array('doubloons', 'food', 'water', 'porcelain', 'spices', 'silk', 'title', 'nationality',
                                     'tobacco', 'rum', 'medicine', 'rafts', 'bank_account', 'bank_loan', 'prisoners', 'character_name');
            
            $uppercase_inventory_items = array('title');

            foreach ($standard as $item) {
                if (isset($updates[$item])) {
                    $value = (isset($updates[$item]['value'])) ? $this->_calc_value($updates[$item], $this->data['game'][$item], 0) : $updates[$item];

                    $sql_updates[$item] = $value;
                    
                    $output[$item]['success'] = $value;
                    
                    if (in_array($item, $inventory_items)) {
                        $change_element_value = in_array($item, $uppercase_inventory_items) ? ucfirst($value) : $value;
                        $output['changeElements']['inventory_' . $item]['text'] = $change_element_value;
                    }
                }
            }

            if (isset($updates['victories']) && is_array($updates['victories']) && count($updates['victories']) > 0) {
                // Handle victories saved as array
                $victories = array();

                foreach ($updates['victories'] as $nationality => $value) {
                    $victories[$nationality] = $value;
                }

                $victories = array_merge($this->data['game']['victories'], $victories);

                $output['changeElements']['inventory_level']['text'] = $victories[$this->data['game']['enemy']] - $victories[$this->data['game']['nationality']];

                $sql_updates['victories'] = json_encode($victories);
            }

            if (isset($updates['victories']) && !is_array($updates['victories'])) {
                // Handle victories saved as json
                $sql_updates['victories'] = $updates['victories'];

                $victories = json_decode($updates['victories'], true);
                $output['changeElements']['inventory_level']['text'] = $victories[$this->data['game']['enemy']] - $victories[$this->data['game']['nationality']];
            }

            if (isset($updates['event']) && is_array($updates['event']) && count($updates['event']) > 0) {
                // Handle events saved as array
                $events = array();

                foreach ($updates['event'] as $event => $value) {
                    $events[$event] = $value;
                }

                $events = array_merge($this->data['game']['event'], $events);
                $sql_updates['event'] = json_encode($events);
            }

            if (isset($updates['stocks']) && !is_array($updates['stocks'])) {
                // Handle stocks saved as json
                $stocks = json_decode($updates['stocks'], true);
                $new_stock_total_worth = array_sum(array_column($stocks, 'worth'));
                $output['changeElements']['inventory_bank_stocks']['text'] = $new_stock_total_worth;

                $sql_updates['stocks'] = $updates['stocks'];
            }

            if (isset($updates['stocks']) && is_array($updates['stocks']) && count($updates['stocks']) > 0) {
                // Handle stocks saved as array
                $stocks = array();

                foreach ($updates['stocks'] as $stock => $value) {
                    if (!isset($value['remove'])) {
                        // Update this stock
                        $stocks[$stock] = $value;
                    }
                }

                $stocks = array_merge($this->data['game']['stocks'], $stocks);

                foreach ($updates['stocks'] as $stock => $value) {
                    if (isset($value['remove'])) {
                        // Remove this stock
                        unset($stocks[$stock]);
                    }
                }

                $new_stock_total_worth = array_sum(array_column($stocks, 'worth'));
                $output['changeElements']['inventory_bank_stocks']['text'] = $new_stock_total_worth;

                $sql_updates['stocks'] = json_encode($stocks);
            }

            if (isset($updates['event']) && !is_array($updates['event'])) {
                // Handle events saved as json
                $sql_updates['event'] = $updates['event'];
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
