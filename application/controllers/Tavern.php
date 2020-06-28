<?php

include('Main.php');

class Tavern extends Main
{
    public function index()
    {
        $this_place = 'tavern';

        if ($this->data['game']['place'] !== $this_place) {
            $updates['place'] = $this_place;
            $result = $this->Game->update($updates);

            if (!isset($result['error'])) {
                $this->data['game']['place'] = $this_place;
            }
        }

        $this->load->library('Tavernlib');
        $this->data['viewdata']['items'] = $this->tavernlib->get_items($this->data['game']);

        $this->load->view_ajax('tavern/view_tavern', $this->data);
    }

    public function buy_post()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $this->load->library('Tavernlib');
        $items = $this->tavernlib->get_items($this->data['game']);
        
        $wanted_item = $this->uri->segment(3);
        
        if (!in_array($wanted_item, array_column($items, 'id'))) {
            return;
        }

        $item = $items[array_search($wanted_item, array_column($items, 'id'))];

        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
            
        if ($item['price_buy'] > $this->data['game']['doubloons']) {
            $data['error'] = 'You don\'t have enough money!';
            echo json_encode($data);
            return;
        }
        
        $data['success'] = 'You bought ' . $item['id'] . ' for yourself and your crew members.';
        $log_input['entry'] = 'bought ' . $item['id'] . ' at the tavern for the crew members.';
        $data['changeElements'] = array();
                
        if ($item['health_increase'] > 0) {
            $data['success'] .= ' The crew health was raised by +' . $item['health_increase'] . '.';
            $log_input['entry'] .= 'The crew health was raised by +' . $item['health_increase'] . '.';
                    
            $db_crew_updates['all']['health'] = "+" . $item['health_increase'];
        }
                
        if ($item['mood_increase'] > 0) {
            $data['success'] .= ' The crew mood was raised by +' . $item['mood_increase'] . '.';
            $log_input['entry'] .= ' The crew mood was raised by +' . $item['mood_increase'] . '.';
                    
            $db_crew_updates['all']['mood'] = "+" . $item['mood_increase'];
        }

        if (isset($db_crew_updates)) {
            $db_crew_result = $this->Crew->update($db_crew_updates);
            $data['changeElements'] = array_merge($data['changeElements'], $db_crew_result['changeElements']);
        }
                
        $db_updates['doubloons']['sub'] = true;
        $db_updates['doubloons']['value'] = $item['price_buy'];
        $db_result = $this->Game->update($db_updates);
                
        if ($db_result['doubloons']['success']) {
            $data['changeElements'] = array_merge($data['changeElements'], $db_result['changeElements']);
                    
            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'coins';
            }
        }

        $this->Log->create($log_input);
        
        echo json_encode($data);
    }

    public function sailors()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        if ($this->data['game']['event_sailors'] === 'banned') {
            redirect($this->data['game']['place']);
        }
        
        if (is_numeric($this->data['game']['event_sailors'])) {
            // Action already set previously
            $action = 'SAILORS_ACTION_JOIN';
            $sailors = $this->data['game']['event_sailors'];
        } else {
            // Generate new action
            $this->load->library('Tavernlib');
        
            $sailors = $this->tavernlib->get_sailors_number_meet($this->data['game']['crew_members']);
            $action = $this->tavernlib->get_sailors_action();
        }

        switch ($action) {
            case 'SAILORS_ACTION_JOIN':
                $this->sailors_join($sailors);
                break;
            case 'SAILORS_ACTION_FIGHT_YOU_WIN':
                $this->sailors_fight_you_win($sailors);
                break;
            case 'SAILORS_ACTION_FIGHT_YOU_LOOSE':
                $this->sailors_fight_you_loose($sailors);
                break;
        }
    }

    private function sailors_join($sailors)
    {
        if (!isset($this->data['game']['event_sailors']) || empty($this->data['game']['event_sailors'])) {
            // Set event parameters if they are not already set
            $this->data['game']['event_sailors'] = $sailors;
            
            $updates['user_id'] = $this->data['user']['id'];
            $updates['event_sailors'] = $sailors;
            $result = $this->Game->update($updates);
        }

        $data['changeElements']['actions_sailors']['disable'] = true;
        $this->data['json'] = json_encode($data);
            
        $this->load->view_ajax('tavern/view_sailors', $this->data);
    }

    private function sailors_fight_you_win($sailors)
    {
        $this->load->library('Tavernlib');

        $loot = $this->tavernlib->get_sailors_win_loot($sailors);

        $db_updates['user_id'] = $this->data['user']['id'];
        $db_updates['doubloons']['add'] = true;
        $db_updates['doubloons']['value'] = $loot;
        $db_updates['event_sailors'] = 'banned';

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'sword_fight';
        }

        $data['success'] = 'You fight with some sailors and take ' . $loot . ' dbl!';
        $data['changeElements']['actions_sailors']['disable'] = true;
        $data['pushState'] = base_url('tavern');
            
        $db_result = $this->Game->update($db_updates);
            
        if ($db_result['doubloons']['success']) {
            $data['changeElements'] = array_merge($data['changeElements'], $db_result['changeElements']);
        }

        $this->data['json'] = json_encode($data);
                    
        $log_input['entry'] = 'fought with some sailors and took ' . $loot . ' dbl.';
        $this->Log->create($log_input);
            
        $this->load->view_ajax('tavern/view_sailors', $this->data);
    }

    private function sailors_fight_you_loose($sailors)
    {
        $this->load->library('Tavernlib');

        $health_loss = $this->tavernlib->get_sailors_loose_health_decrease();

        $crew_updates['all']['health'] = $health_loss;
        $crew_db_result = $this->Crew->update($crew_updates);
                    
        if (!$crew_db_result['success']) {
            return;
        }

        $data['error'] = 'You fight with some sailors and you lose! Your crews health is decreased by ' . $health_loss . '%!';
        $log_input['entry'] = 'fought with some sailors and lost. The crews health is decreased by ' . $health_loss . '%.';
    
        if ($crew_db_result['death_count'] > 0) {
            $data['error'] .= ' Unfortunately ' . $crew_db_result['death_count'] . ' of your crew members died because of injuries.';
            $log_input['entry'] .= $crew_db_result['death_count'] . ' of the crew members died because of injuries.';
        }
                        
        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'sword_fight';
        }

        $data['changeElements'] = $crew_db_result['changeElements'];
        $data['changeElements']['actions_sailors']['disable'] = true;

        $data['pushState'] = base_url('tavern');
    
        $this->data['json'] = json_encode($data);
    
        $db_updates['event_sailors'] = 'banned';
        $this->Game->update($db_updates);
                                    
        $this->Log->create($log_input);
                        
        $this->load->view_ajax('tavern/view_sailors', $this->data);
    }

    public function sailors_join_accept()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        if (empty($this->data['game']['event_sailors']) || $this->data['game']['event_sailors'] === 'banned') {
            return;
        }

        $sailors = $this->data['game']['event_sailors'];

        // Create new crew members
        $crew_db_create['user_id'] = $this->data['user']['id'];
        $crew_db_create['number_of_men'] = $sailors;
        $crew_db_create['week'] = $this->data['game']['week'];
        $crew_db_create['nation'] = $this->data['game']['nation'];
        $crew_db_response = $this->Crew->create($crew_db_create);

        $data['success'] = 'You took ' . $sailors . ' sailors in as your crew members.';
        $this->data['msg'] = 'You took ' . $sailors . ' sailors in as your crew members.';

        $data['changeElements']['offer']['remove'] = true;
        $data['changeElements']['actions_sailors']['disable'] = true;
        $data['pushState'] = base_url('tavern');
                    
        $data['changeElements'] = array_merge($data['changeElements'], $crew_db_response['changeElements']);
                    
        $manned_cannons = (floor(($this->data['game']['crew_members'] + $sailors) / 2) > $this->data['game']['cannons']) ? $this->data['game']['cannons'] : floor(($this->data['game']['crew_members'] + $sailors) / 2);
        $data['changeElements']['inventory_manned_cannons']['text'] = $manned_cannons;
                    
        $log_input['entry'] = 'took ' . $sailors . ' sailors from the tavern in as crew members.';
        $this->Log->create($log_input);
            
        $db_updates['user_id'] = $this->data['user']['id'];
        $db_updates['event_sailors'] = 'banned';
        $this->Game->update($db_updates);
            
        echo json_encode($data);
    }

    public function sailors_join_decline()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        if (empty($this->data['game']['event_sailors']) || $this->data['game']['event_sailors'] === 'banned') {
            return;
        }

        $sailors = $this->data['game']['event_sailors'];

        $data['info'] = 'You had a nice conversation with the lads, but eventually told them off.';
        $this->data['msg'] = 'You had a nice conversation with the lads, but eventually told them off.';
                
        $data['changeElements']['offer']['remove'] = true;
        $data['changeElements']['actions_sailors']['disable'] = true;
        $data['pushState'] = base_url('tavern');
            
        $this->data['game']['event_sailors'] = 'banned';

        $db_updates['user_id'] = $this->data['user']['id'];
        $db_updates['event_sailors'] = 'banned';
        $this->Game->update($db_updates);
            
        echo json_encode($data);
    }

    public function gamble()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $this->data['viewdata']['next_bet'] = floor($this->data['game']['doubloons'] * 0.1);

        $this->load->view_ajax('tavern/view_gamble', $this->data);
    }

    public function gamble_post()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $bet = $this->input->post('bet');

        if ($bet > $this->data['game']['doubloons']) {
            $data['error'] = 'You don\'t have enough money!';
            echo json_encode($data);
            return;
        }
        
        if ($bet <= 0) {
            $data['error'] = 'You cannot bet less than 1 dbl!';
            echo json_encode($data);
            return;
        }
        
        $this->load->library('Tavernlib');

        list($gamble_result, $gamble_profit) = $this->tavernlib->get_gamble_result($bet);
        
        switch ($gamble_result) {
            case 'GAMBLE_WIN_JACKPOT':
                $data['success'] = 'JACKPOT!! You made a bet for ' . $bet . ' doubloons and won ' . $gamble_profit . ' doubloons!';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and won ' . $gamble_profit . ' dbl.';
                $sound = 'cheering';
                break;
            case 'GAMBLE_WIN':
                $data['success'] = 'You made a bet for ' . $bet . ' doubloons and won ' . $gamble_profit . ' doubloons!';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and won ' . $gamble_profit . ' dbl.';
                $sound = 'cheering';
                break;
            case 'GAMBLE_LOOSE':
                $data['info'] = 'You made a bet for ' . $bet . ' doubloons and lost.';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and lost.';
                $sound = 'dices';
                break;
        }

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = $sound;
        }
            
        $new_money = floor($this->data['game']['doubloons'] - $bet);
        $new_money += $gamble_profit;

        $bet_percentage = ($new_money > 0) ? $bet / $this->data['game']['doubloons'] : 0;
        $next_bet = floor($new_money * $bet_percentage);

        $updates['doubloons']['value'] = $new_money;
        $result = $this->Game->update($updates);
    
        if (isset($result['doubloons']['success'])) {
            $data['changeElements'] = $result['changeElements'];
        }
            
        $data['changeElements']['current_money']['val'] = $new_money;
        $data['changeElements']['last_bet']['val'] = $next_bet;
        $data['event'] = 'tavern-gamble-post';

        $this->Log->create($log_input);
        
        echo json_encode($data);
    }
}
