<?php

include('Main.php');

class Tavern extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'tavern';

        if ($this->user['game']['place'] != $this_place) {
            $updates['place'] = $this_place;
            $result = $this->Game->update($updates);
            
            if (! isset($result['error'])) {
                $this->user['game']['place'] = $this_place;
            }
        }
    }

    public function index()
    {
        $this->user['prices'] = $this->config->item('prices');
    
        $this->load->view_ajax('tavern/view_tavern', $this->user);
    }

    public function buy()
    {
        $this->user['prices'] = $this->config->item('prices');
    
        $this->load->view_ajax('tavern/view_tavern', $this->user);
    }

    public function buy_post()
    {
        $products = array('dinners', 'wenches', 'wine', 'rum');
        $product = $this->uri->segment(3);
        
        if (in_array($product, $products)) {
            $this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));

            $prices = $this->config->item('prices');
            $cost = floor(($this->user['game']['crew_members'] + 1) * $prices['tavern_' . $product]['buy']);

            switch ($product) {
                case 'dinners':
                    $health_increase = 25;
                    $mood_increase = 3;
                    break;
                case 'wenches':
                    $health_increase = 10;
                    $mood_increase = 5;
                    break;
                case 'wine':
                    $mood_increase = 7;
                    break;
                case 'rum':
                    $mood_increase = 10;
                    break;
            }
            
            if ($cost > $this->user['game']['doubloons']) {
                $data['error'] = 'You don\'t have enough money!';
            } else {
                $data['success'] = 'You bought ' . $product . ' for yourself and your crew members.';
                $log_input['entry'] = 'bought ' . $product . ' at the tavern for the crew members.';
                $data['changeElements'] = array();
                
                if (isset($health_increase) && $health_increase > 0) {
                    $data['success'] .= ' The crew health was raised by +' . $health_increase . '.';
                    $log_input['entry'] .= 'The crew health was raised by +' . $health_increase . '.';
                    
                    $updates['all']['health'] = "+" . $health_increase;
                    $result = $this->Crew->update($updates);
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                }
                
                if (isset($mood_increase) && $mood_increase > 0) {
                    $data['success'] .= ' The crew mood was raised by +' . $mood_increase . '.';
                    $log_input['entry'] .= ' The crew mood was raised by +' . $mood_increase . '.';
                    
                    $updates['all']['mood'] = "+" . $mood_increase;
                    $result = $this->Crew->update($updates);
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                }
                
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = $cost;
                $result = $this->Game->update($updates);
                
                if ($result['doubloons']['success']) {
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                    
                    if ($this->user['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'coins';
                    }
                }
                
                $this->Log->create($log_input);
            }
        
            echo json_encode($data);
        }
    }

    public function sailors()
    {
        if ($this->user['game']['event_sailors'] != 'banned') {
            if ($this->user['game']['crew_members'] < 11) {
                $sailors = round($this->user['game']['crew_members'] * (rand(10, 25) / 100));
            } elseif ($this->user['game']['crew_members'] > 11 && $this->user['game']['crew_members'] < 20) {
                $sailors = round($this->user['game']['crew_members'] * (rand(8, 15) / 100));
            } else {
                $sailors = round($this->user['game']['crew_members'] * (rand(4, 10) / 100));
            }
            if ($sailors < 1) {
                $sailors = 1;
            }
            
            $action = rand(1, 100);

            if ($action <= 50) {
                //The sailors will ask to join your crew
                $this->user['game']['event_sailors'] = $sailors;
                
                $updates['user_id'] = $this->user['user']['id'];
                $updates['event_sailors'] = $sailors;
                $result = $this->Game->update($updates);
                
                $this->load->view_ajax('tavern/view_sailors', $this->user);
            } elseif ($action > 50 && $action <= 85) {
                //The sailors will fight you and you will win
                $loot = $sailors * rand(10, 100);
                $updates['user_id'] = $this->user['user']['id'];
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $loot;
                $updates['event_sailors'] = 'banned';

                if ($this->user['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'sword_fight';
                }
                $data['success'] = 'You fight with some sailors and take ' . $loot . ' dbl!';
                $data['changeElements']['actions_sailors']['remove'] = true;
                $data['pushState'] = base_url('tavern');
                
                $result = $this->Game->update($updates);
                
                if ($result['doubloons']['success']) {
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                }
                        
                $log_input['entry'] = 'fought with some sailors and took ' . $loot . ' dbl.';
                $this->Log->create($log_input);
                
                $this->load->view_ajax('tavern/view_sailors', $this->user);
            } elseif ($action > 85) {
                //The sailors will fight you and you will lose
                $this->user['crew'] = $this->Crew->get(array('user_id' => $this->user['user']['id']));
                
                $health_loss = 0 - rand(10, 30);
            
                $crew_updates['all']['health'] = $health_loss;
                $crew_result = $this->Crew->update($crew_updates);
                
                if ($crew_result['success']) {
                    $data['error'] = 'You fight with some sailors and you lose! Your crews health is decreased by ' . $health_loss . '%!';
                    $log_input['entry'] = 'fought with some sailors and lost. The crews health is decreased by ' . $health_loss . '%.';

                    if ($crew_result['death_count'] > 0) {
                        $data['error'] .= ' Unfortunately ' . $crew_result['death_count'] . ' of your crew members died because of injuries.';
                        $log_input['entry'] .= $crew_result['death_count'] . ' of the crew members died because of injuries.';
                    }
                    
                    if ($this->user['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'sword_fight';
                    }
                    $data['changeElements']['actions_sailors']['remove'] = true;
                    
                    $this->user['game']['crew_health_lowest'] = $crew_result['min_health'];
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);

                    $data['pushState'] = base_url('tavern');
                    
                    $game_updates['event_sailors'] = 'banned';
                    $game_result = $this->Game->update($game_updates);
                                
                    $this->Log->create($log_input);
                    
                    $this->load->view_ajax('tavern/view_sailors', $this->user);
                }
            }
        } else {
            redirect($this->user['game']['place']);
        }
    }

    public function sailors_post()
    {
        if (! empty($this->user['game']['event_sailors']) && $this->user['game']['event_sailors'] != 'banned') {
            $sailors = (! empty($this->user['game']['event_sailors']) && $this->user['game']['event_sailors'] != 'banned') ? $this->user['game']['event_sailors'] : null;
            $answer = ($this->uri->segment(3) == 'yes') ? 'Yes' : 'No';

            if ($sailors && $answer == 'Yes') {
                $crew_input['user_id'] = $this->user['user']['id'];
                $crew_input['number_of_men'] = $sailors;
                $crew_input['week'] = $this->user['game']['week'];
                $crew_input['nation'] = $this->user['game']['nation'];
                $crew_output = $this->Crew->create($crew_input);

                if ($crew_output['created_crew_count'] == $sailors) {
                    $data['success'] = 'You took ' . $sailors . ' sailors in as your crew members.';

                    $data['changeElements']['offer']['remove'] = true;
                    $data['changeElements']['actions_sailors']['remove'] = true;
                    $data['pushState'] = base_url('tavern');
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
                    
                    $manned_cannons = (floor(($this->user['game']['crew_members'] + $sailors) / 2) > $this->user['game']['cannons']) ? $this->user['game']['cannons'] : floor(($this->user['game']['crew_members'] + $sailors) / 2);
                    $data['changeElements']['inventory_manned_cannons']['text'] = $manned_cannons;
                    
                    $log_input['entry'] = 'took ' . $sailors . ' sailors from the tavern in as crew members.';
                    $this->Log->create($log_input);
                } else {
                    $data['error'] = 'Something went wrong... no new crew members added.';
                }
            } else {
                $data['info'] = 'You had a nice conversation with the lads, but eventually told them off.';
                
                $data['changeElements']['offer']['remove'] = true;
                $data['changeElements']['actions_sailors']['remove'] = true;
                $data['pushState'] = base_url('tavern');
            }
            
            
            $this->user['game']['event_sailors'] = 'banned';

            $updates['user_id'] = $this->user['user']['id'];
            $updates['event_sailors'] = 'banned';
            $result = $this->Game->update($updates);
            
            echo json_encode($data);
        }
    }

    public function gamble()
    {
        $this->user['game']['next_bet'] = floor($this->user['game']['doubloons'] * 0.1);

        $this->load->view_ajax('tavern/view_gamble', $this->user);
    }

    public function gamble_post()
    {
        $bet = $this->input->post('bet');
        $prev_money = $this->user['game']['doubloons'];
        $chance = rand(1, 42);

        if ($bet > $prev_money) {
            $data['error'] = 'You don\'t have enough money!';
        } elseif ($bet < 1) {
            $data['error'] = 'You cannot bet less than 1 dbl!';
        } else {
            if ($chance <= 7) {
                //Won!
                $won = floor($bet * rand(2, 5));
                $data['success'] = 'You made a bet for ' . $bet . ' doubloons and won ' . $won . ' doubloons!';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and won ' . $won . ' dbl.';
                
                if ($this->user['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'cheering';
                }
            } elseif ($chance == 42) {
                //Jackpot!
                $won = floor($bet * 20);
                $data['success'] = 'JACKPOT!! You made a bet for ' . $bet . ' doubloons and won ' . $won . ' doubloons!';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and won ' . $won . ' dbl.';
                
                if ($this->user['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'cheering';
                }
            } else {
                //Lost
                $data['info'] = 'You made a bet for ' . $bet . ' doubloons and lost.';
                $log_input['entry'] = 'made a bet for ' . $bet . ' dbl at the tavern and lost.';
                
                if ($this->user['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'dices';
                }
            }
            
            $new_money = floor($prev_money - $bet);
            $new_money = (isset($won)) ? $new_money + $won : $new_money;
            $bet_percentage = ($new_money > 0) ? $bet / $prev_money : 0;
            $next_bet = floor($new_money * $bet_percentage);

            $updates['doubloons']['value'] = $new_money;
            $result = $this->Game->update($updates);
    
            if (isset($result['doubloons']['success'])) {
                $data['changeElements'] = $result['changeElements'];
            }
            
            $data['changeElements']['current_money']['val'] = $new_money;
            $data['changeElements']['last_bet']['value'] = $next_bet;
            $data['event'] = 'tavern-gamble-post';

            $this->Log->create($log_input);
        }
        
        echo json_encode($data);
    }
}

/*  End of tavern.php */
/* Location: ./application/controllers/tavern.php */
