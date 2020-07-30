<?php

class User extends CI_Model
{
    public function get($index, $value, $filter = false)
    {
        if ($filter) {
            //use $filter as 'password' or 'password, username, phone' to get more than one
            $this->db->select($filter);
        }
        
        $this->db->where($index, $value);
        $user_data = $this->db->get($this->db->user_table);
        $user_data = ($user_data->num_rows() > 0) ? $user_data->row_array() : false;
        
        return $user_data;
    }
    
    public function user_exists($id)
    {
        if (strpos($id, '@')) {
            $sql = "SELECT COUNT(id) AS duplicates FROM " . $this->db->user_table . " WHERE email = '" . $id . "'";
        } else {
            $sql = "SELECT COUNT(id) AS duplicates FROM " . $this->db->user_table . " WHERE id = '" . $id . "'";
        }
        
        $sql_result = $this->db->query($sql)->row();
        
        return ($sql_result->duplicates > 0) ? true : false;
    }
    
    public function get_players($input = false)
    {
        $sql = "SELECT id, verified, name, character_avatar, character_gender, email, created, character_name, level, week, last_activity, UNIX_TIMESTAMP(game.last_activity) AS last_activity_unix FROM " . $this->db->user_table . " AS user
				LEFT JOIN " . $this->db->game_table . " AS game ON user.id = game.user_id
				";
        
        if (isset($input['verified_only'])) {
            $sql .= " WHERE verified = 1";
        } elseif (isset($input['temp_only'])) {
            $sql .= " WHERE verified = 0";
        } elseif (isset($input['online_only'])) {
            $sql .= " WHERE verified = 1 AND game.last_activity > NOW() - INTERVAL 3 MINUTE";
        }

        $sql .= " ORDER BY game.last_activity DESC";

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    public function create($user_input)
    {
        //Register user data and return the user ID for creating the game db later on
        $this->db->insert($this->db->user_table, $user_input);
    }
    
    public function update($index, $value, $changes)
    {
        $this->db->where($index, $value);
        $this->db->update($this->db->user_table, $changes);
    }
    
    public function erase_temp_users()
    {
        $sql = "SELECT id FROM " . $this->db->user_table . " WHERE created < DATE_SUB(NOW(), INTERVAL 24 HOUR) AND verified = 0";
        $temp_users = $this->db->query($sql)->result_array();
        $erased_users = 0;
    
        foreach ($temp_users as $user) {
            $this->erase($user['id']);
            $erased_users++;
        }
        
        return $erased_users;
    }
    
    public function erase($user_id)
    {
        $erase_user_id = array('user_id' => $user_id);
        $erase_id = array('id' => $user_id);
        
        $this->db->delete($this->db->user_table, $erase_id);
        $this->db->delete($this->db->game_table, $erase_user_id);
        $this->db->delete($this->db->crew_table, $erase_user_id);
        $this->db->delete($this->db->ship_table, $erase_user_id);
        $this->db->delete($this->db->log_table, $erase_user_id);
        $this->db->delete($this->db->history_table, $erase_user_id);
        
        if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $user_id . '.jpg')) {
            unlink(APPPATH . '../assets/images/profile_pictures/' . $user_id . '.jpg');
        }
        
        if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $user_id . '_thumb.jpg')) {
            unlink(APPPATH . '../assets/images/profile_pictures/' . $user_id . '_thumb.jpg');
        }
    }
}

/* End of file user.php */
/* Location: ./application/models/user.php */
