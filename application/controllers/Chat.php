<?php

include('Main.php');

class Chat extends Main
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->user['user']['verified'] == 1) {
            $data['runJS'] = 'runChat()';
            $this->user['json'] = json_encode($data);

            $this->load->view_ajax('chat/view_chat.php', $this->user);
        }
    }

    public function update_chat()
    {
        //Manually updates the last activity to be able to track online users
        $sql = "UPDATE " . $this->db->game_table . " SET last_activity = now() WHERE user_id = '" . $this->user['user']['id'] . "'";
        $this->db->query($sql);
    
        $chat_content = $this->db->query('SELECT * FROM `' . $this->db->chat_table . '` WHERE id > ((SELECT MAX(id) from `' . $this->db->chat_table . '`) - 30) ORDER BY id ASC');
        $this->user['chat'] = $chat_content->result_array();
        
        $player_input['online_only'] = true;
        $this->user['online_users'] = $this->User->get_players($player_input);

        $this->load->view_ajax('chat/view_content', $this->user);
    }

    public function post_chat()
    {
        if ($this->user['user']['verified'] == 1) {
            $chat_post['entry'] = strip_tags($this->input->post('entry'));

            if (! empty($chat_post['entry'])) {
                $chat_post['user_id'] = $this->user['user']['id'];
                $chat_post['name'] = $this->user['user']['name'];
                $chat_post['time'] = date('Y-m-d H:i:s', time());
                $chat_post['place'] = ucwords($this->user['game']['town']) . 's ' . $this->user['game']['place'];

                $this->db->insert($this->db->chat_table, $chat_post);
            }
        }
    }
}

/*  End of chat.php */
/* Location: ./application/controllers/chat.php */
