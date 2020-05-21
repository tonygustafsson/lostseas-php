<?php

class Crew extends CI_Model
{
    public function get($input)
    {
        if (isset($input['order'])) {
            $this->db->order_by($input['order']);
        }
        
        $this->db->where('user_id', $input['user_id']);
        $this->db->order_by('id', 'asc');
        
        $crew_data = $this->db->get($this->db->crew_table);
        $crew_data = $crew_data->result_array();
        
        //Create a new array where the keys are the crew members ID. Easier to manage.
        $crew_array = array();
        foreach ($crew_data as $man) {
            $crew_array[$man['id']] = $man;
            $crew_array[$man['id']]['friendly_mood'] = $this->gamelib->get_crew_friendly_mood($crew_array[$man['id']]['mood']);
        }
        
        return $crew_array;
    }
    
    public function get_brief($user_id)
    {
        $sql = "SELECT COUNT(id) as num_crew, MIN(mood) AS min_mood, MIN(health) as min_health FROM " . $this->db->crew_table . " WHERE user_id = '" . $user_id . "'";
        $query = $this->db->query($sql);

        return $query->row_array();
    }
    
    public function get_latest($user_id)
    {
        $sql = "SELECT * FROM " . $this->db->crew_table . " WHERE user_id = '" . $user_id . "' ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function create($input)
    {
        $this->load->helper('file');
        
        $created_crew = array();
        
        $input['number_of_men'] = (isset($input['number_of_men'])) ? $input['number_of_men'] : 1;
        $input['week'] = (isset($input['week'])) ? $input['week'] : 1;
        $input['health'] = (isset($input['health'])) ? $input['health'] : 100;
        $input['mood'] = (isset($input['mood'])) ? $input['mood'] : 10;
        $input['doubloons'] = (isset($input['doubloons'])) ? $input['doubloons'] : 0;
        
        if (! isset($input['nationality']) || $input['nationality'] == 'random') {
            $nation_array = array('england', 'france', 'holland', 'spain');
            $input['nationality'] = $nation_array[rand(0, 3)];
        }
        
        //Load mens names
        $names_men = read_file('assets/lists/names_' . $input['nationality'] . '_men.txt');
        if (! $names_men) {
            return false;
        }
        $names_men = explode("\n", $names_men);
        
        //Load womens names
        $names_women = read_file('assets/lists/names_' . $input['nationality'] . '_women.txt');
        if (! $names_women) {
            return false;
        }
        $names_women = explode("\n", $names_women);
        
        //Load surnames
        $names_surnames = read_file('assets/lists/names_' . $input['nationality'] . '_surnames.txt');
        if (! $names_surnames) {
            return false;
        }
        $names_surnames = explode("\n", $names_surnames);
        
        $hair_colors = array('blonde', 'dark blonde', 'light blonde', 'dark', 'black', 'brown', 'dark brown', 'light brown', 'yellow', 'red', 'ginger');
        $hair_styles = array('short', 'half long', 'long', 'cropped', 'stylish', 'back combed', 'wavy', 'curly', 'wispy');
        $eye_colors = array('blue', 'light blue', 'dark blue', 'green', 'dark green', 'light green', 'brown', 'light brown', 'dark brown', 'grey', 'dark grey', 'light grey');
        $cloth_colors = array('blue', 'grey', 'green', 'yellow', 'purple', 'red', 'brown', 'orange', 'black');
        $characteristics = array('rich', 'strong', 'weak', 'fat', 'handsome', 'proper', 'beautiful', 'masculine', 'feminine', 'snobbish', 'charming', 'geeky', 'ordinary', 'plain', 'intelligent', 'wise', 'aggressive', 'grumpy', 'happy', 'calm');
        $characteristics_quantities = array('a bit ', 'very ', '');
        
        for ($x = 0; $x < $input['number_of_men']; $x++) {
            $crew_data = array();
            $crew_data['user_id'] = $input['user_id'];
            $crew_data['gender'] = (rand(0, 2) == 0) ? 'F' : 'M';
            $crew_data['mood'] = $input['mood'];
            $crew_data['nationality'] = $input['nationality'];
            $crew_data['health'] = $input['health'];
            $crew_data['doubloons'] = $input['doubloons'];
            $crew_data['created'] = $input['week'];

            $speak_gender = ($crew_data['gender'] == 'M') ? 'he' : 'she';
            $speak_gender2 = ($crew_data['gender'] == 'M') ? 'his' : 'her';
            $characteristic_quantity_1 = $characteristics_quantities[rand(0, 2)];
            $characteristic_quantity_2 = $characteristics_quantities[rand(0, 2)];

            $crew_data['description'] = ucfirst($speak_gender) . ' is ' . rand(13, 70) . ' years old with ' . $hair_colors[rand(0, count($hair_colors) - 1)] . ', ' . $hair_styles[rand(0, count($hair_styles) - 1)] . ' hair and ' . $eye_colors[rand(0, count($eye_colors) - 1)] . ' eyes. ' . ucfirst($speak_gender2) . ' pants is ' . $cloth_colors[rand(0, count($cloth_colors) - 1)] . ', the sweater is ' . $cloth_colors[rand(0, count($cloth_colors) - 1)] . ' and ' . $speak_gender . ' seems ' . $characteristic_quantity_1 . $characteristics[rand(0, count($characteristics) - 1)] . ' and ' . $characteristic_quantity_2 . $characteristics[rand(0, count($characteristics) - 1)] . '.';
            $crew_data['name'] = ($crew_data['gender'] == 'M') ? $names_men[rand(0, count($names_men) - 1)] : $names_women[rand(0, count($names_women) - 1)];
            $crew_data['name'] .= ' ' . $names_surnames[rand(0, count($names_surnames) - 1)];
    
            $this->db->insert($this->db->crew_table, $crew_data);
            
            $latest_crew = $this->get_latest($input['user_id']);
            $crew_data['id'] = $latest_crew['id'];
            
            $created_crew[] = $crew_data;
        }
        
        $output = array();
        
        if (isset($this->user['user']['id'])) {
            //Return new crew data for the inventory, if it's not a temp user
            $new_crew = $this->get_brief($this->user['user']['id']);
        
            $new_health_symbol = $this->gamelib->get_crew_health_symbol($new_crew['min_health']);
            $output['changeElements']['inventory_crew']['text'] = $new_crew['num_crew'];
            $output['changeElements']['inventory_crew_health_link']['title'] = 'You have ' . $new_crew['num_crew'] . ' crew members with the health ' . $new_crew['min_health'] . '%';
            $output['changeElements']['inventory_crew_health_img']['src'] = base_url('assets/images/icons/' . $new_health_symbol . '.png');

            $new_friendly_mood = $this->gamelib->get_crew_friendly_mood($new_crew['min_mood']);
            $output['changeElements']['inventory_crew_mood']['text'] = $new_friendly_mood;
            $output['changeElements']['inventory_crew_mood_link']['title'] = 'Your crew is ' . $new_friendly_mood . ' (Mood ' . $new_crew['min_mood'] . ')';
            $output['changeElements']['inventory_crew_mood_img']['src'] = base_url('assets/images/icons/smiley_' . $new_friendly_mood . '.png');
        
            //Return some other statistics
            $output['success'] = true;
            $output['min_health'] = $new_crew['min_health'];
            $output['min_mood'] = $new_crew['min_mood'];
            $output['min_friendly_mood'] = $new_friendly_mood;
            $output['num_crew'] = $new_crew['num_crew'];
            $output['created_crew_count'] = count($created_crew);
            $output['created_crew'] = $created_crew;
        }
        
        return $output;
    }

    public function update($updates)
    {
        $affected_crew_members = 0;
        $crew_died = array();
        
        if (isset($updates['player'])) {
            //Get another players info
            $all_crew = $updates['player']['crew'];
            $user_id = $updates['player']['user']['id'];
            unset($updates['player']);
        } else {
            //Get your own info
            $all_crew = $this->user['crew'];
            $user_id = $this->user['user']['id'];
        }
    
        if (isset($updates['all'])) {
            //If you want to set this value for all crews
            foreach ($all_crew as $this_crew) {
                foreach ($updates['all'] as $key => $val) {
                    $updates[$this_crew['id']][$key] = $updates['all'][$key];
                }
            }

            unset($updates['all']);
        }
    
        foreach ($all_crew as $this_crew) {
            //For ALL crews, already loaded
            if (isset($updates[$this_crew['id']])) {
                $affected_crew_members++;
                $changes = array();

                //Gives error on foreach if index does not exist
                foreach ($updates[$this_crew['id']] as $update => $value) {
                    //For each update for this crew, if none, keep on going
                    if (substr($value, 0, 1) == "+") { //Add a number, like +20
                        $changes[$update] = $this_crew[$update] + substr($value, 1); #Remove + at the beginning from $value
                        $changes[$update] = ($update == 'health' && $changes[$update] > 100) ? 100 : $changes[$update];
                        $changes[$update] = ($update == 'mood' && $changes[$update] > 40) ? 40 : $changes[$update];
                    } elseif (substr($value, 0, 1) == "-") { //Subtract a number, like -20
                        $changes[$update] = $this_crew[$update] - substr($value, 1); #Remove - at the beginning from $value
                        $changes[$update] = ($update == 'health' && $changes[$update] < 0) ? 0 : $changes[$update];
                        $changes[$update] = ($update == 'mood' && $changes[$update] < -10) ? -10 : $changes[$update];
                    } else { //The value will be statically set, like 20
                        $changes[$update] = $value;
                        $changes[$update] = ($update == 'health' && $changes[$update] > 100) ? 100 : $changes[$update];
                        $changes[$update] = ($update == 'health' && $changes[$update] < 0) ? 0 : $changes[$update];
                        $changes[$update] = ($update == 'mood' && $changes[$update] > 40) ? 40 : $changes[$update];
                        $changes[$update] = ($update == 'mood' && $changes[$update] < -10) ? -10 : $changes[$update];
                    }
                    
                    if ($update == 'health' && $changes[$update] < 1) {
                        $crew_died[$this_crew['id']]['id'] = $this_crew['id'];
                        $erase_input['id'] = $this_crew['id'];
                        $this->erase($erase_input);
                    }
                }
                
                $this->db->where('id', $this_crew['id']);
                $this->db->update($this->db->crew_table, $changes);
            }
        }
        
        //Return new crew data for the inventory
        $new_crew = $this->get_brief($user_id);
        
        $new_health_symbol = $this->gamelib->get_crew_health_symbol($new_crew['min_health']);
        $output['changeElements']['inventory_crew']['text'] = $new_crew['num_crew'];
        $output['changeElements']['inventory_crew_health_link']['title'] = 'You have ' . $new_crew['num_crew'] . ' crew members with the health ' . $new_crew['min_health'] . '%';
        $output['changeElements']['inventory_crew_health_img']['src'] = base_url('assets/images/icons/' . $new_health_symbol . '.png');

        $new_friendly_mood = $this->gamelib->get_crew_friendly_mood($new_crew['min_mood']);
        $output['changeElements']['inventory_crew_mood']['text'] = $new_friendly_mood;
        $output['changeElements']['inventory_crew_mood_link']['title'] = 'Your crew is ' . $new_friendly_mood . ' (Mood ' . $new_crew['min_mood'] . ')';
        $output['changeElements']['inventory_crew_mood_img']['src'] = base_url('assets/images/icons/smiley_' . $new_friendly_mood . '.png');
        
        //Return some other statistics
        $output['success'] = true;
        $output['min_health'] = $new_crew['min_health'];
        $output['min_mood'] = $new_crew['min_mood'];
        $output['min_friendly_mood'] = $new_friendly_mood;
        $output['affected_crew_members'] = $affected_crew_members;
        $output['crew_died'] = $crew_died;
        $output['death_count'] = count($crew_died);
        $output['num_crew'] = $new_crew['num_crew'];
        
        return $output;
    }

    public function erase($input)
    {
        if (isset($input['delete_all']) && isset($input['user_id']) && $input['delete_all'] == true) {
            //Erase all crew members for a certain user
            $this->db->delete($this->db->crew_table, array('user_id' => $input['user_id']));
            
            $output['action'] = 'all';
            $output['user_id'] = $input['user_id'];
        } elseif (isset($input['delete_random']) && isset($input['user_id'])) {
            $sql = "DELETE FROM " . $this->db->crew_table . " WHERE user_id = '" . $input['user_id'] . "' ORDER BY RAND() LIMIT " . $input['delete_random'];
            $this->db->query($sql);
            
            $output['action'] = 'random';
            $output['user_id'] = $input['user_id'];
        } else {
            //Erase a single crew member
            $this->db->delete($this->db->crew_table, array('id' => $input['id']));
            
            $output['action'] = 'single';
            $output['id'] = $input['id'];
        }
        
        //Return new crew data for the inventory
        $new_crew = $this->get_brief($this->user['user']['id']);
        
        $new_health_symbol = $this->gamelib->get_crew_health_symbol($new_crew['min_health']);
        $output['changeElements']['inventory_crew']['text'] = $new_crew['num_crew'];
        $output['changeElements']['inventory_crew_health_link']['title'] = 'You have ' . $new_crew['num_crew'] . ' crew members with the health ' . $new_crew['min_health'] . '%';
        $output['changeElements']['inventory_crew_health_img']['src'] = base_url('assets/images/icons/' . $new_health_symbol . '.png');

        $new_friendly_mood = $this->gamelib->get_crew_friendly_mood($new_crew['min_mood']);
        $output['changeElements']['inventory_crew_mood']['text'] = $new_friendly_mood;
        $output['changeElements']['inventory_crew_mood_link']['title'] = 'Your crew is ' . $new_friendly_mood . ' (Mood ' . $new_crew['min_mood'] . ')';
        $output['changeElements']['inventory_crew_mood_img']['src'] = base_url('assets/images/icons/smiley_' . $new_friendly_mood . '.png');
        
        return $output;
    }
}

/* End of file crew.php */
/* Location: ./application/models/crew.php */
