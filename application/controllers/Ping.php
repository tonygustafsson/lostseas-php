<?php

include('Main.php');

class Ping extends Main
{
    public function index()
    {
        $logged_in = (isset($this->data['user'])) ? true : false;

        if (!$logged_in) {
            return;
        }

        // Updates the last activity to be able to track online users
        $game_sql = "UPDATE " . $this->db->game_table . " SET last_activity = now() WHERE user_id = '" . $this->data['user']['id'] . "'";
        $this->db->query($game_sql);

        $data['weather'] = $this->gamelib->get_weather();
        echo json_encode($data);
    }
}
