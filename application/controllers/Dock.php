<?php

include('Main.php');

class Dock extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'dock';
        
        if ($this->data['game']['place'] != $this_place) {
            $updates['place'] = $this_place;
            $result = $this->Game->update($updates);
            
            if (! isset($result['error'])) {
                $this->data['game']['place'] = $this_place;
            }
        }
    }

    public function index()
    {
        $data['changeElements'] = array();
    
        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
        $new_mood = $this->data['game']['crew_lowest_mood'] + 1;
        $updates['all']['mood'] = $new_mood;
        $crew_output = $this->Crew->update($updates);
        
        if ($crew_output['success']) {
            $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
        }

        if ($this->data['game']['nationality'] == $this->data['game']['nation']) {
            $title_input['level'] = $this->data['game']['level'];
            $title_info = $this->gamelib->get_title($title_input);
            $new_title = $title_info['title'];
            $better_than = $title_info['better_than'];

            if ($new_title != $this->data['game']['title'] && in_array($this->data['game']['title'], $better_than)) {
                $this->data['game']['todo'][]['cityhall_governor'] = 'I\'m sure the towns governor would like to have a word with you!';
            }
        }

        if ($this->data['game']['ships'] < 1) {
            $this->data['game']['todo'][]['ship'] = 'You do not own a ship, you must buy a new one! Take a loan if you have to!';
        }

        if ($this->data['game']['ship_health_lowest'] < 80) {
            $this->data['game']['todo'][]['ship'] = 'Some of your ships is in need of repair. You should visit the shipyard...';
        }

        if (rand(1, 3) == 1 && $this->data['game']['ships'] < 2) {
            $this->data['game']['todo'][]['ship'] = 'You only own one ship, which make you vulnerable if you lose a battle. You should save up some money and buy a new one  at the shipyard.';
        }

        if ($this->data['game']['food'] < ($this->data['game']['needed_food'] * 5)) {
            $this->data['game']['todo'][]['food'] = 'You should buy ' . abs(($this->data['game']['needed_food'] * 5) - $this->data['game']['food']) . ' cartons of food to last 5 more weeks at sea.';
        }

        if ($this->data['game']['water'] < ($this->data['game']['needed_water'] * 5)) {
            $this->data['game']['todo'][]['water'] = 'You should buy ' . abs(($this->data['game']['needed_water'] * 5) - $this->data['game']['water']) . ' barrels of water if you want to last 5 more weeks at sea.';
        }

        if (floor($this->data['game']['crew_members'] / 2) > $this->data['game']['cannons']) {
            $this->data['game']['todo'][]['cannon'] = 'You have more crew members than usable cannons, if possible, you should buy ' . (floor($this->data['game']['crew_members'] / 2) - $this->data['game']['cannons']) . ' more cannons.';
        }

        if ($this->data['game']['crew_members'] < 1) {
            $this->data['game']['todo'][]['crew-man'] = 'You do not have any crew members, you have to get new onces. Try the tavern or the market!';
        }

        if ($this->data['game']['crew_lowest_mood'] < 6) {
            $this->data['game']['todo'][]['crew-man'] = 'Some of your crew is not that happy. You should buy them something to drink before you leave.';
        }

        if ($this->data['game']['crew_health_lowest'] < 80) {
            $this->data['game']['todo'][]['crew-man'] = 'Some of your crew is not totally healthy. You should visit the healer, or buy them some dinners at the tavern.';
        }

        if ($this->data['game']['prisoners'] > 0 && $this->data['game']['nation'] == $this->data['game']['nationality']) {
            $this->data['game']['todo'][]['prisoners'] = 'You have ' . $this->data['game']['prisoners'] . ' prisoners to deliver to the City Hall.';
        }

        $barter_goods = array('porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
        $barter_msg = '';
        foreach ($barter_goods as $item => $container) {
            if ($this->data['game'][$item] > 0) {
                $barter_msg .= ' ' . $this->data['game'][$item] . ' ' . $container . ' of ' . $item . ',';
            }
        }
        
        if (! empty($barter_msg)) {
            $this->data['game']['todo'][]['barrels'] = 'You could sell' . substr($barter_msg, 0, -1) . '.';
        }

        if ($this->data['user']['sound_effects_play'] == 1 && ($this->data['user']['email'] != "" || (time() - strtotime($this->data['user']['created'])) > 180)) {
            $data['playSound'] = 'cheering';
        }
        
        $data['changeElements']['nav_dock']['visibility'] = 'block';
        $data['changeElements']['nav_harbor']['visibility'] = 'none';
        $this->data['json'] = json_encode($data);

        $this->load->view_ajax('dock/view_dock', $this->data);
    }
}

/*  End of dock.php */
/* Location: ./application/controllers/dock.php */
