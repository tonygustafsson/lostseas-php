<?php

include('Main.php');

class Market extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'market';
        
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
        $this->load->view_ajax('market/view_market', $this->data);
    }

    public function goods()
    {
        if ($this->data['game']['event_market_goods'] != 'banned') {
            list($item, $quantity, $cost, $total_cost) = (! empty($this->data['game']['event_market_goods'])) ? explode('###', $this->data['game']['event_market_goods']) : array(null, null, null, null);

            if ($item === null || $quantity === null || $cost === null || $total_cost === null) {
                $items = array(
                    'food' => 16,
                    'water' => 12,
                    'porcelain' => 35,
                    'spices' => 20,
                    'silk' => 45,
                    'tobacco' => 75,
                    'rum' => 150
                );

                $item = array_rand($items);
                $cost = floor($items[$item] * (rand(50, 100) / 100));
                $quantity = rand(1, 50);
                $total_cost = $quantity * $cost;

                $this->data['game']['event_market_goods'] = $updates['event_market_goods'] = $item . '###' . $quantity . '###' . $cost . '###' . $total_cost;

                $this->Game->update($updates);
            }

            $this->load->view_ajax('market/view_goods', $this->data);
        }
    }

    public function goods_post()
    {
        if (! empty($this->data['game']['event_market_goods']) && $this->data['game']['event_market_goods'] != 'banned') {
            $data['changeElements'] = array();
            $answer = $this->uri->segment(3);
        
            if ($answer == 'yes') {
                list($item, $quantity, $cost, $total_cost) = explode('###', $this->data['game']['event_market_goods']);

                if ($cost <= $this->data['game']['doubloons']) {
                    $data['success'] = 'You bought ' . $quantity . ' cartons of ' . $item . ' for ' . $total_cost . ' dbl at the market!';

                    $updates['event_market_goods'] = 'banned';
                    $updates['doubloons']['sub'] = true;
                    $updates['doubloons']['value'] = $total_cost;
                    $updates[$item]['add'] = true;
                    $updates[$item]['value'] = $quantity;
                    $result = $this->Game->update($updates);
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'coins';
                    }
                    
                    $log_input['entry'] = 'bought ' . $quantity . ' cartons of ' . $item . ' for ' . $total_cost . ' dbl at the market.';
                    $this->Log->create($log_input);
                }
            } else {
                $data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
            }

            $data['changeElements']['offer']['remove'] = true;
            $data['changeElements']['action_goods']['remove'] = true;
            $data['pushState'] = base_url('market');
            
            echo json_encode($data);
        }
    }

    public function slaves()
    {
        if ($this->data['game']['event_market_slaves'] != 'banned') {
            list($slaves, $health, $cost) = (! empty($this->data['game']['event_market_slaves'])) ? explode('###', $this->data['game']['event_market_slaves']) : array(null, null, null);

            if ($slaves === null || $health === null || $cost === null) {
                $slaves = ($this->data['game']['crew_members'] < 10) ? rand(1, 3) : rand(1, 12);
                $health = rand(20, 100);
                $cost = round($slaves * rand(200, 1200));

                $this->data['game']['event_market_slaves'] = $updates['event_market_slaves'] = $slaves . '###' . $health . '###' . $cost;

                $result = $this->Game->update($updates);
            }

            $this->load->view_ajax('market/view_slaves', $this->data);
        }
    }

    public function slaves_post()
    {
        if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned') {
            $answer = $this->uri->segment(3);
            $data['changeElements'] = array();
        
            if ($answer == 'yes') {
                list($slaves, $health, $cost) = explode('###', $this->data['game']['event_market_slaves']);

                if ($cost <= $this->data['game']['doubloons']) {
                    $crew_input['user_id'] = $this->data['user']['id'];
                    $crew_input['number_of_men'] = $slaves;
                    $crew_input['week'] = $this->data['game']['week'];
                    $crew_input['nationality'] = $this->data['game']['nation'];
                    $crew_input['health'] = $health;
                    $crew_result = $this->Crew->create($crew_input);
                    
                    if ($crew_result['created_crew_count'] == $slaves) {
                        $data['success'] = 'You bought ' . $slaves . ' slaves, that is now your crew members, for ' . $cost . ' dbl at the market!';

                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);

                        $updates['event_market_slaves'] = 'banned';
                        $updates['doubloons']['sub'] = true;
                        $updates['doubloons']['value'] = $cost;
                        $game_result = $this->Game->update($updates);
                        $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                        
                        if ($this->data['user']['sound_effects_play'] == 1) {
                            $data['playSound'] = 'coins';
                        }
                        
                        $log_input['entry'] = 'bought ' . $slaves . ' slaves, that is now part of the crew members, for ' . $cost . ' dbl at the market.';
                        $this->Log->create($log_input);
                    } else {
                        $data['error'] = 'Something went wrong when creating new crew members!';
                    }
                }
            } else {
                $data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
            }

            $data['changeElements']['offer']['remove'] = true;
            $data['changeElements']['action_slaves']['remove'] = true;
            $data['pushState'] = base_url('market');
            
            echo json_encode($data);
        }
    }
    
    public function healer()
    {
        $injured_crew = 0;
        $total_injury = 0;
        
        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));

        foreach ($this->data['crew'] as $man) {
            if ($man['health'] < 100) {
                $injured_crew++;
                $total_injury += 100 - $man['health'];
            }
        }

        $this->data['cost'] = floor($total_injury * 0.75);
        $this->data['injured_crew'] = $injured_crew;

        $this->load->view_ajax('market/view_healer', $this->data);
    }

    public function healer_post()
    {
        $answer = $this->uri->segment(3);
        $data['changeElements'] = array();
    
        if ($answer == 'yes') {
            $injured_crew = 0;
            $total_injury = 0;

            $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));

            foreach ($this->data['crew'] as $man) {
                if ($man['health'] < 100) {
                    $injured_crew++;
                    $total_injury += 100 - $man['health'];
                }
            }

            $cost = floor($total_injury * 0.75);

            if ($injured_crew > 0 && $cost <= $this->data['game']['doubloons']) {
                $crew_updates['all']['health'] = 100;
                $crew_output = $this->Crew->update($crew_updates);

                if ($crew_output['success']) {
                    $data['success'] = 'You let the towns healer heal ' . $injured_crew . ' of your crew members for ' . $cost . ' dbl!';

                    $updates['doubloons']['sub'] = true;
                    $updates['doubloons']['value'] = $cost;
                    $game_result = $this->Game->update($updates);
                    
                    $data['pushState'] = base_url('market');
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                    
                    $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);

                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'healing';
                    }
                    
                    $log_input['entry'] = 'let the towns healer heal ' . $injured_crew . ' of the crew members for ' . $cost . ' dbl.';
                    $this->Log->create($log_input);
                } else {
                    $data['error'] = 'Something went wrong when healing your crew!';
                }
            }
        } else {
            $data['info'] = 'You had a nice conversation with the lady, but eventually told her off.';
        }

        $data['changeElements']['offer']['remove'] = true;
        
        echo json_encode($data);
    }
}

/*  End of market.php */
/* Location: ./application/controllers/market.php */
