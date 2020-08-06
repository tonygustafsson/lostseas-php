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
            $log_input['entry'] .= ' The crew health was raised by +' . $item['health_increase'] . '.';
                    
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

        $log_input['type'] = 'crew-management';
        $this->Log->create($log_input);
        
        echo json_encode($data);
    }

    public function sailors()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_sailors']) ? $this->data['game']['event']['tavern_sailors'] : null;

        if (isset($event['banned']) && $event['banned']) {
            return;
        }
        
        if (isset($event['joiners'])) {
            // Action already set previously
            $action = 'SAILORS_ACTION_JOIN';
            $sailors = $event['joiners'];
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
        $event = isset($this->data['game']['event']['tavern_sailors']) ? $this->data['game']['event']['tavern_sailors'] : null;

        if (!isset($event['joiners'])) {
            // Set event parameters if they are not already set
            $this->data['game']['event']['tavern_sailors']['joiners'] = $sailors;
            
            $updates['user_id'] = $this->data['user']['id'];
            $updates['event']['tavern_sailors']['joiners'] = $sailors;
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
        $db_updates['event']['tavern_sailors']['banned'] = true;

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
        $log_input['type'] = 'crew-management';
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
    
        $db_updates['event']['tavern_sailors']['banned'] = true;
        $this->Game->update($db_updates);
                                    
        $log_input['type'] = 'crew-management';
        $this->Log->create($log_input);
                        
        $this->load->view_ajax('tavern/view_sailors', $this->data);
    }

    public function sailors_join_accept()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_sailors']) ? $this->data['game']['event']['tavern_sailors'] : null;

        if (isset($event['banned']) && $event['banned']) {
            return;
        }

        $sailors = $event['joiners'];

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
        $log_input['type'] = 'crew-management';
        $this->Log->create($log_input);
            
        $db_updates['user_id'] = $this->data['user']['id'];
        $db_updates['event']['tavern_sailors']['banned'] = true;
        $this->Game->update($db_updates);
            
        echo json_encode($data);
    }

    public function sailors_join_decline()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_sailors']) ? $this->data['game']['event']['tavern_sailors'] : null;

        if (isset($event['banned']) && $event['banned']) {
            return;
        }

        $sailors = $event['joiners'];

        $data['info'] = 'You had a nice conversation with the lads, but eventually told them off.';
        $this->data['msg'] = 'You had a nice conversation with the lads, but eventually told them off.';
                
        $data['changeElements']['offer']['remove'] = true;
        $data['changeElements']['actions_sailors']['disable'] = true;
        $data['pushState'] = base_url('tavern');
            
        $this->data['game']['event']['tavern_sailors']['banned'] = true;

        $db_updates['user_id'] = $this->data['user']['id'];
        $db_updates['event']['tavern_sailors']['banned'] = true;

        $this->Game->update($db_updates);
            
        echo json_encode($data);
    }

    public function dice()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $this->data['viewdata']['next_bet'] = floor($this->data['game']['doubloons'] * 0.1);

        $this->load->view_ajax('tavern/view_dice', $this->data);
    }

    public function dice_post()
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
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl when playing dice and won ' . $gamble_profit . ' dbl.';
                $sound = 'cheering';
                break;
            case 'GAMBLE_WIN':
                $data['success'] = 'You made a bet for ' . $bet . ' doubloons and won ' . $gamble_profit . ' doubloons!';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl when playing dice and won ' . $gamble_profit . ' dbl.';
                $sound = 'cheering';
                break;
            case 'GAMBLE_LOOSE':
                $data['info'] = 'You made a bet for ' . $bet . ' doubloons and lost.';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl when playing dice and lost.';
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
        $data['triggerJsEvents'][] = 'tavern-dice-post';
        
        $log_input['type'] = 'gambling';
        $this->Log->create($log_input);
        
        echo json_encode($data);
    }

    public function blackjack()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $this->load->library('Blackjacklib');
        $event = isset($this->data['game']['event']['tavern_blackjack']) ? $this->data['game']['event']['tavern_blackjack'] : null;

        if (isset($event)) {
            $this->data['viewdata']['total_value'] = $this->blackjacklib->get_card_total_value($event['cards']);

            for ($i = 0; $i < count($event['cards']); $i++) {
                $this->data['viewdata']['cards'][] = $this->blackjacklib->get_card($event['cards'][$i]);
            }
        } else {
            $this->data['viewdata']['cards'] = array();
        }

        $this->data['viewdata']['next_bet'] = floor($this->data['game']['doubloons'] * 0.1);

        $this->load->view_ajax('tavern/view_blackjack', $this->data);
    }

    public function blackjack_play()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_blackjack']) ? $this->data['game']['event']['tavern_blackjack'] : null;

        if (isset($event)) {
            // Prevent playing again before finishing a game
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
        
        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'coins';
        }

        $this->load->library('Blackjacklib');
            
        $new_money = floor($this->data['game']['doubloons'] - $bet);
        $bet_percentage = ($new_money > 0) ? $bet / $this->data['game']['doubloons'] : 0;
        $next_bet = floor($new_money * $bet_percentage);

        $first_card = $this->blackjacklib->create_card();
        $data['cards'] = array($this->blackjacklib->get_card($first_card));

        $event = array('bet' => $bet, 'cards' => array($first_card));
        $updates['event']['tavern_blackjack'] = $event;
        $updates['doubloons']['value'] = $new_money;
        $result = $this->Game->update($updates);
    
        if (isset($result['doubloons']['success'])) {
            $data['changeElements'] = $result['changeElements'];
        }
            
        for ($i = 0; $i < count($event['cards']); $i++) {
            $this->data['viewdata']['cards'][] = $this->blackjacklib->get_card($event['cards'][$i]);
        }

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'card';
        }

        $this->data['viewdata']['total_value'] = $this->blackjacklib->get_card_total_value(array($first_card));
        $this->data['viewdata']['event'] = $event;
        $this->data['game']['event']['tavern_blackjack'] = json_encode($event);
    
        $data['loadView'] = $this->load->view('tavern/view_blackjack', $this->data, true);
      
        echo json_encode($data);
    }

    public function blackjack_draw()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_blackjack']) ? $this->data['game']['event']['tavern_blackjack'] : null;

        if (!isset($event)) {
            // Prevent drawing new card if it hasn't started playing
            return;
        }

        $this->load->library('Blackjacklib');

        $new_card = $this->blackjacklib->create_card();
        $event['cards'][] = $new_card;

        $updates['event']['tavern_blackjack'] = $event;
        $this->Game->update($updates);

        for ($i = 0; $i < count($event['cards']); $i++) {
            $this->data['viewdata']['cards'][] = $this->blackjacklib->get_card($event['cards'][$i]);
        }

        $total_value = $this->blackjacklib->get_card_total_value($event['cards']);
        $this->data['viewdata']['total_value'] = $total_value;

        if ($this->blackjacklib->is_bust($total_value)) {
            $updates['event']['tavern_blackjack'] = null;
            $this->data['game']['event']['tavern_blackjack'] = null;

            $dealer_max = random_int(17, 18);
            $dealer_value = 0;
            $dealer_cards = array();
    
            while ($dealer_value < $dealer_max && $dealer_value <= $total_value) {
                // Draw cards until dealer is satisfied
                $dealer_card = $this->blackjacklib->create_card();
                $dealer_cards[] = $dealer_card;
                $dealer_value = $this->blackjacklib->get_card_total_value($dealer_cards);
                $this->data['viewdata']['dealer_cards'][] = $this->blackjacklib->get_card($dealer_card);
            }

            $this->data['viewdata']['total_dealer_value'] = $dealer_value;

            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'argh';
            }

            $this->Game->update($updates);

            $this->data['viewdata']['busted'] = true;
            $data['info'] = 'You busted and lost your money to the bank.';

            $log_input['entry'] = 'played Black Jack and busted. Lost ' . $event['bet'] . ' dbl.';
            $log_input['type'] = 'gambling';
            $this->Log->create($log_input);
        } else {
            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'card';
            }

            $this->data['game']['event']['tavern_blackjack'] = $event;
        }
    
        $data['loadView'] = $this->load->view('tavern/view_blackjack', $this->data, true);
      
        echo json_encode($data);
    }

    public function blackjack_stand()
    {
        if ($this->data['game']['place'] !== 'tavern') {
            return;
        }

        $event = isset($this->data['game']['event']['tavern_blackjack']) ? $this->data['game']['event']['tavern_blackjack'] : null;

        if (!$event) {
            // Prevent stand if it hasn't started playing
            return;
        }

        $this->load->library('Blackjacklib');

        for ($i = 0; $i < count($event['cards']); $i++) {
            $this->data['viewdata']['cards'][] = $this->blackjacklib->get_card($event['cards'][$i]);
        }

        $total_value = $this->blackjacklib->get_card_total_value($event['cards']);
        $dealer_max = random_int(17, 18);
        $dealer_value = 0;
        $dealer_cards = array();

        while ($dealer_value < $dealer_max && $dealer_value <= $total_value) {
            // Draw cards until dealer is satisfied
            $dealer_card = $this->blackjacklib->create_card();
            $dealer_cards[] = $dealer_card;
            $dealer_value = $this->blackjacklib->get_card_total_value($dealer_cards);
            $this->data['viewdata']['dealer_cards'][] = $this->blackjacklib->get_card($dealer_card);
        }

        $this->data['viewdata']['total_dealer_value'] = $dealer_value;
        $this->data['viewdata']['total_value'] = $total_value;

        if ($dealer_value <= 21 && $dealer_value >= $total_value) {
            // Player looses
            $this->data['viewdata']['dealer_won'] = true;
            $data['info'] = 'You lost to the dealer and lost your money.';

            $log_input['entry'] = 'played Black Jack and lost ' . $event['bet'] . ' dbl to the dealer.';
            $log_input['type'] = 'gambling';
            $this->Log->create($log_input);

            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'argh';
            }
        } else {
            // Dealer looses
            list($blackjack, $winning_sum) = $this->blackjacklib->get_winning_sum($event['bet'], $event['cards']);
            $updates['doubloons'] = $this->data['game']['doubloons'] + $winning_sum;

            $this->data['viewdata']['player_won'] = true;

            if ($blackjack) {
                $data['success'] = 'BLACK JACK! You won ' . $winning_sum . ' doubloons!';
                $log_input['entry'] = 'got BLACK JACK at the tavern and won ' . $winning_sum . ' dbl.';
            } else {
                $data['success'] = 'You won ' . $winning_sum . ' doubloons!';
                $log_input['entry'] = 'played Black Jack and won ' . $winning_sum . ' dbl.';
            }

            $log_input['type'] = 'gambling';
            $this->Log->create($log_input);

            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'cheering';
            }
        }

        $this->data['game']['event']['tavern_blackjack'] = null;

        $updates['event']['tavern_blackjack'] = null;
        $result = $this->Game->update($updates);

        if (isset($result['doubloons']['success'])) {
            $data['changeElements'] = $result['changeElements'];
        }

        $data['loadView'] = $this->load->view('tavern/view_blackjack', $this->data, true);
      
        echo json_encode($data);
    }
}
