<?php

class History extends CI_Model
{
    public function get($input)
    {
        $input['user_id'] = (isset($input['user_id'])) ? $input['user_id'] : $this->data['user']['id'];
        $input['weeks'] = (isset($input['weeks'])) ? $input['weeks'] : 50;
    
        $sql = "SELECT * FROM " . $this->db->history_table . " WHERE user_id = '" . $input['user_id'] . "' ORDER BY created DESC LIMIT " . $input['weeks'];
        $history_data = $this->db->query($sql);
        $history_data = ($history_data->num_rows() > 0) ? array_reverse($history_data->result_array()) : false;
        
        return $history_data;
    }

    public function get_chart_data($history_data)
    {
        $chart_data = array();
        $chart_labels = array();
                
        if ($history_data) {
            foreach ($history_data as $index => $history) {
                if ($index % 4) {
                    // Take every fourth row
                    continue;
                }

                $chart_data['labels'][] = 'W' . $history['week'];

                $chart_data['doubloons'][] = $history['doubloons'];
                $chart_data['ships'][] = $history['ships'];
                $chart_data['crew_members'][] = $history['crew_members'];
                $chart_data['crew_health'][] = $history['crew_health'];
                $chart_data['crew_mood'][] = $history['crew_mood'];
                $chart_data['stock_value'][] = $history['stock_value'];
                $chart_data['victories'][] = $history['victories'];
                $chart_data['level'][] = $history['level'];
            }
        }
    
        return $chart_data;
    }

    public function create($input = false)
    {
        $prices = $this->config->item('prices');
    
        //Register history data
        $input['user_id'] = (isset($input['user_id'])) ? $input['user_id'] : $this->data['user']['id'];
        $input['week'] = (isset($input['week'])) ? $input['week'] : $this->data['game']['week'];
        $input['doubloons'] = (isset($input['doubloons'])) ? $input['doubloons'] : ($this->data['game']['doubloons'] + $this->data['game']['bank_account']) - $this->data['game']['bank_loan'];
        $input['ships'] = (isset($input['ships'])) ? $input['ships'] : $this->data['game']['ships'];
        $input['crew_members'] = (isset($input['crew_members'])) ? $input['crew_members'] : $this->data['game']['crew_members'];
        $input['crew_mood'] = (isset($input['crew_mood'])) ? $input['crew_mood'] : $this->data['game']['crew_lowest_mood'];
        $input['crew_health'] = (isset($input['crew_health'])) ? $input['crew_health'] : $this->data['game']['crew_health_lowest'];
        $input['cannons'] = (isset($input['cannons'])) ? $input['cannons'] : $this->data['game']['cannons'];
        $input['stock_value'] = (isset($input['stock_value'])) ? $input['stock_value'] : ($this->data['game']['food'] * $prices['food']['sell']) + ($this->data['game']['water'] * $prices['water']['sell']) + ($this->data['game']['porcelain'] * $prices['porcelain']['sell']) + ($this->data['game']['spices'] * $prices['spices']['sell']) + ($this->data['game']['silk'] * $prices['silk']['sell']) + ($this->data['game']['tobacco'] * $prices['tobacco']['sell']) + ($this->data['game']['rum'] * $prices['rum']['sell']) + ($this->data['game']['medicine'] * $prices['medicine']['sell']);
        $input['level'] = (isset($input['level'])) ? $input['level'] : $this->data['game']['level'];
        $input['victories'] = (isset($input['victories'])) ? $input['victories'] : $this->data['game']['victories_total'];
        
        $this->db->insert($this->db->history_table, $input);
    }
    
    public function erase($user_id)
    {
        $this->db->delete($this->db->history_table, array('user_id' => $user_id));
    }
}

/* End of file history.php */
/* Location: ./application/models/history.php */
