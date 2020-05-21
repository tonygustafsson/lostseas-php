<?php

class History extends CI_Model
{
    public function get($input)
    {
        $input['user_id'] = (isset($input['user_id'])) ? $input['user_id'] : $this->user['user']['id'];
        $input['weeks'] = (isset($input['weeks'])) ? $input['weeks'] : 20;
    
        $sql = "SELECT * FROM " . $this->db->history_table . " WHERE user_id = '" . $input['user_id'] . "' ORDER BY created DESC LIMIT " . $input['weeks'];
        $history_data = $this->db->query($sql);
        $history_data = ($history_data->num_rows() > 0) ? $history_data->result_array() : false;
        
        return $history_data;
    }

    public function create($input = false)
    {
        $prices = $this->config->item('prices');
    
        //Register history data
        $input['user_id'] = (isset($input['user_id'])) ? $input['user_id'] : $this->user['user']['id'];
        $input['week'] = (isset($input['week'])) ? $input['week'] : $this->user['game']['week'];
        $input['doubloons'] = (isset($input['doubloons'])) ? $input['doubloons'] : ($this->user['game']['doubloons'] + $this->user['game']['bank_account']) - $this->user['game']['bank_loan'];
        $input['ships'] = (isset($input['ships'])) ? $input['ships'] : $this->user['game']['ships'];
        $input['crew_members'] = (isset($input['crew_members'])) ? $input['crew_members'] : $this->user['game']['crew_members'];
        $input['crew_mood'] = (isset($input['crew_mood'])) ? $input['crew_mood'] : $this->user['game']['crew_lowest_mood'];
        $input['crew_health'] = (isset($input['crew_health'])) ? $input['crew_health'] : $this->user['game']['crew_health_lowest'];
        $input['cannons'] = (isset($input['cannons'])) ? $input['cannons'] : $this->user['game']['cannons'];
        $input['stock_value'] = (isset($input['stock_value'])) ? $input['stock_value'] : ($this->user['game']['food'] * $prices['food']['sell']) + ($this->user['game']['water'] * $prices['water']['sell']) + ($this->user['game']['porcelain'] * $prices['porcelain']['sell']) + ($this->user['game']['spices'] * $prices['spices']['sell']) + ($this->user['game']['silk'] * $prices['silk']['sell']) + ($this->user['game']['tobacco'] * $prices['tobacco']['sell']) + ($this->user['game']['rum'] * $prices['rum']['sell']) + ($this->user['game']['medicine'] * $prices['medicine']['sell']);
        $input['level'] = (isset($input['level'])) ? $input['level'] : $this->user['game']['level'];
        $input['victories'] = (isset($input['victories'])) ? $input['victories'] : $this->user['game']['total_victories'];
        
        $this->db->insert($this->db->history_table, $input);
    }
    
    public function erase($user_id)
    {
        $this->db->delete($this->db->history_table, array('user_id' => $user_id));
    }
}

/* End of file history.php */
/* Location: ./application/models/history.php */
