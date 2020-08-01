<?php

class Ship extends CI_Model
{
    public function get($user_id)
    {
        $this->db->order_by('id', 'asc');
        $this->db->where(array('user_id' => $user_id));
        $ship_data = $this->db->get($this->db->ship_table);
        $ship_data = $ship_data->result_array();
        
        // Create a new array where the keys are the ships ID. Easier to manage.
        $ship_array = array();
        foreach ($ship_data as $ship) {
            $ship_array[$ship['id']] = $ship;
        }
        
        ksort($ship_array);
        
        return $ship_array;
    }
    
    public function get_latest($user_id)
    {
        $sql = "SELECT * FROM " . $this->db->ship_table . " WHERE user_id = '" . $user_id . "' ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql);

        return $query->row_array();
    }
    
    public function create($input)
    {
        $this->load->helper('file');

        // Load ship names
        $names_ships = read_file('assets/lists/names_ships.txt');
        $names_ships = explode("\n", $names_ships);
        
        $input['ship_type'] = (isset($input['ship_type'])) ? $input['ship_type'] : 'brig';
        $input['health'] = (isset($input['health'])) ? $input['health'] : 100;
        $input['age'] = (isset($input['age'])) ? $input['age'] : 0;
        
        $ship_data['user_id'] = $input['user_id'];
        $ship_data['type'] = $input['ship_type'];
        $ship_data['health'] = $input['health'];
        $ship_data['age'] = $input['age'];
        $ship_data['name'] = $names_ships[rand(0, count($names_ships))];
        
        $this->db->insert($this->db->ship_table, $ship_data);
        
        $output['success'] = true;
        
        // Get the new ship
        $new_ship = $this->get_latest($input['user_id']);
        $ship_data['id'] = $new_ship['id'];

        $output['ships'] = (isset($this->data['game']['ships'])) ? $this->data['game']['ships'] + 1 : 1;
        $output['created_ship'] = $ship_data;
        
        // Fix for temp users that don't have ship_health_lowest
        $ship_health_lowest = (isset($this->data['game']['ship_health_lowest'])) ? $this->data['game']['ship_health_lowest'] : 100;
        $output['new_lowest_health'] = ($ship_data['health'] < $ship_health_lowest) ? $ship_data['health'] : $ship_health_lowest;
        $output['changeElements'] = $this->gamelib->get_inventory_ship($output['ships'], $output['new_lowest_health']);
        
        return $output;
    }
    
    public function update($updates)
    {
        $affected_ships = 0;
        $new_lowest_health = 100;
        $ship_destroyed = array();
        
        if (isset($updates['player'])) {
            // Get another players info
            $all_ships = $updates['player']['ship'];
            $user_id = $updates['player']['user']['id'];
            unset($updates['player']);
        } else {
            // Get your own info
            $all_ships = $this->data['ship'];
            $user_id = $this->data['user']['id'];
        }
        
        if (isset($updates['all'])) {
            // If you want to set this value for all ships
            foreach ($all_ships as $this_ship) {
                foreach ($updates['all'] as $key => $val) {
                    $updates[$this_ship['id']][$key] = $updates['all'][$key];
                }
            }

            unset($updates['all']);
        }
    
        foreach ($all_ships as $this_ship) {
            // For ALL ships, already loaded
            if (isset($updates[$this_ship['id']])) {
                $affected_ships++;
                $changes = array();
                
                // Gives error on foreach if index does not exist
                foreach ($updates[$this_ship['id']] as $update => $value) {
                    // For each update for this ship, if none, keep on going
                    if (substr($value, 0, 1) == "+") {
                        // Add a number, like +20
                        $changes[$update] = $this_ship[$update] + substr($value, 1); #Remove + at the beginning from $value
                        $changes[$update] = ($update == 'health' && $changes[$update] > 100) ? 100 : $changes[$update];
                    } elseif (substr($value, 0, 1) == "-") {
                        // Subtract a number, like -20
                        $changes[$update] = $this_ship[$update] - substr($value, 1); #Remove - at the beginning from $value
                        $changes[$update] = ($update == 'health' && $changes[$update] < 0) ? 0 : $changes[$update];
                    } else {
                        // The value will be statically set, like 20
                        $changes[$update] = $value;
                        $changes[$update] = ($update == 'health' && $changes[$update] > 100) ? 100 : $changes[$update];
                        $changes[$update] = ($update == 'health' && $changes[$update] < 0) ? 0 : $changes[$update];
                    }
                    
                    if ($update == 'health' && $changes[$update] < 1) {
                        // Destroy ship if health is 0
                        $ship_destroyed[$this_ship['id']]['id'] = $this_ship['id'];
                        $erase_input['id'] = $this_ship['id'];
                        $this->erase($erase_input);
                    } elseif ($update == 'health' && $changes[$update] > 0) {
                        $new_lowest_health = ($changes[$update] < $new_lowest_health) ? $changes[$update] : $new_lowest_health;
                    }
                }
                
                $this->db->where('id', $this_ship['id']);
                $this->db->update($this->db->ship_table, $changes);
            } else {
                if ($this_ship['health'] < $new_lowest_health) {
                    // We need to count this even we don't change the ship so we get the right value
                    $new_lowest_health = $this_ship['health'];
                }
            }
        }
        
        $output['success'] = true;
        $output['affected_ships'] = $affected_ships;
        $output['new_lowest_health'] = $new_lowest_health;
        $output['ship_destroyed'] = $ship_destroyed;
        $output['ship_destroyed_count'] = count($ship_destroyed);
        
        // Get the new ships
        $new_ships = $this->get($user_id);
        $output['ships'] = count($new_ships);

        $output['changeElements'] = $this->gamelib->get_inventory_ship($output['ships'], $output['new_lowest_health']);
        
        return $output;
    }
    
    public function erase($input)
    {
        if (isset($input['delete_all']) && isset($input['user_id']) && $input['delete_all'] == true) {
            // Erase all ships for a certain user
            $this->db->delete($this->db->ship_table, array('user_id' => $input['user_id']));
            
            $output['action'] = 'all';
            $output['user_id'] = $input['user_id'];
            $output['new_lowest_health'] = 0;
        } else {
            // Erase a single ship
            $this->db->delete($this->db->ship_table, array('id' => $input['id']));
            
            $output['success'] = true;
            $output['action'] = 'single';
            $output['id'] = $input['id'];
            
            $output['new_lowest_health'] = 100;
            foreach ($this->data['ship'] as $this_ship) {
                if ($this_ship['id'] != $input['id'] && $this_ship['health'] < $output['new_lowest_health']) {
                    $output['new_lowest_health'] = $this_ship['health'];
                }
            }
        }
        
        // Get the new ships
        $new_ships = $this->get($this->data['user']['id']);
        $output['ships'] = count($new_ships);

        $output['changeElements'] = $this->gamelib->get_inventory_ship($output['ships'], $output['new_lowest_health']);
        
        return $output;
    }
}
