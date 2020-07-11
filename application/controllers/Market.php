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
        $event = isset($this->data['game']['event']['market']) ? $this->data['game']['event']['market'] : null;
        $new_event = array();

        if (!isset($event['items']) && !isset($event['slaves'])) {
            // Goods

            $possible_items = array(
                    'food' => 16,
                    'water' => 12,
                    'porcelain' => 35,
                    'spices' => 20,
                    'silk' => 45,
                    'medicine' => 40,
                    'tobacco' => 75,
                    'rum' => 150,
                    'cannons' => 300
                );
            
            $available_items = array();
            $available_items_number = random_int(1, 4);

            for ($i = 0; $i < $available_items_number; $i++) {
                $item = array_rand($possible_items);
                $item_cost = floor($possible_items[$item] * (rand(50, 100) / 100));
                $quantity = rand(1, 50);
                $cost = $quantity * $item_cost;

                $available_items[] = array('item' => $item, 'quantity' => $quantity, 'cost' => $cost);
            }

            $new_event['items'] = $available_items;

            // Slaves
            $slaves_for_sale = random_int(0, 1);

            if ($slaves_for_sale) {
                $slaves_quantity = $this->data['game']['crew_members'] < 10 ? random_int(1, 3) : random_int(1, 12);
                $slaves_health = random_int(20, 100);
                $slaves_cost = round($slaves_quantity * random_int(200, 1200));

                $new_event['slaves'] = array('quantity' => $slaves_quantity, 'cost' => $slaves_cost, 'health' => $slaves_health);
            }

            $this->data['game']['event']['market'] = $new_event;
            $updates['event']['market'] = $new_event;

            $this->Game->update($updates);
        }

        $this->load->view_ajax('market/view_market', $this->data);
    }

    public function buy()
    {
        $event = isset($this->data['game']['event']['market']) ? $this->data['game']['event']['market'] : null;

        if (!$event) {
            return;
        }

        $item = $this->uri->segment(3);
        $item_index = array_search($item, array_column($event['items'], 'item'));

        if ($item_index === false) {
            $data['error'] = 'This option is not available.';
            echo json_encode($data);
            return;
        }

        $matching_item = $event['items'][$item_index];

        if ($matching_item['cost'] > $this->data['game']['doubloons']) {
            $data['error'] = 'You don\'t have enough money to buy this item.';
            echo json_encode($data);
            return;
        }

        unset($event['items'][$item_index]);
        $event['items'] = array_values($event['items']);
        $updates['event']['market'] = $event;
        $this->data['game']['event']['market'] = $event;

        $updates['doubloons']['sub'] = true;
        $updates['doubloons']['value'] = $matching_item['cost'];
        $updates[$matching_item['item']]['add'] = true;
        $updates[$matching_item['item']]['value'] = $matching_item['quantity'];

        $result = $this->Game->update($updates);

        $data['changeElements'] = $result['changeElements'];

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'coins';
        }
            
        $log_input['entry'] = 'bought ' . $matching_item['quantity'] . ' of ' . $matching_item['item'] . ' for ' . $matching_item['cost'] . ' dbl at the market.';
        $this->Log->create($log_input);

        $data['success'] = 'You bought ' . $matching_item['quantity'] . ' of ' . $matching_item['item'] . ' for ' . $matching_item['cost'] . ' dbl.';
        $data['loadView'] = $this->load->view('market/view_market', $this->data, true);
        $data['event'] = 'updated-dom';

        echo json_encode($data);
    }

    public function buy_slaves()
    {
        $event = isset($this->data['game']['event']['market']) ? $this->data['game']['event']['market'] : null;

        if (!$event || !isset($event['slaves'])) {
            $data['error'] = 'This option is not available.';
            echo json_encode($data);
            return;
        }

        if ($event['slaves']['cost'] > $this->data['game']['doubloons']) {
            $data['error'] = 'You don\'t have enough money to buy these slaves.';
            echo json_encode($data);
            return;
        }

        $crew_input['user_id'] = $this->data['user']['id'];
        $crew_input['number_of_men'] = $event['slaves']['quantity'];
        $crew_input['week'] = $this->data['game']['week'];
        $crew_input['nationality'] = $this->data['game']['nation'];
        $crew_input['health'] = $event['slaves']['health'];
        $crew_result = $this->Crew->create($crew_input);

        if ($crew_result['created_crew_count'] !== $event['slaves']['quantity']) {
            $data['error'] = 'Something wen\'t wrong while taking the slaves captive.';
            echo json_encode($data);
            return;
        }

        $log_input['entry'] = 'bought ' . $event['slaves']['quantity'] . ' slaves, that is now part of the crew members, for ' . $event['slaves']['cost'] . ' dbl at the market.';
        $this->Log->create($log_input);

        $data['success'] = 'You bought ' . $event['slaves']['quantity'] . ' slaves, that is now your crew members, for ' . $event['slaves']['cost'] . ' dbl at the market!';

        $updates['doubloons']['sub'] = true;
        $updates['doubloons']['value'] = $event['slaves']['cost'];

        unset($event['slaves']);
        $updates['event']['market'] = $event;
        $this->data['game']['event']['market'] = $event;

        $result = $this->Game->update($updates);

        $data['changeElements'] = array_merge($result['changeElements'], $crew_result['changeElements']);

        
        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'coins';
        }

        $data['loadView'] = $this->load->view('market/view_market', $this->data, true);
        $data['event'] = 'updated-dom';

        echo json_encode($data);
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
            $data['info'] = 'You had a nice conversation with the healer, but eventually walked away.';
        }

        $data['loadView'] = $this->load->view('market/view_market', $this->data, true);
        $data['event'] = 'updated-dom';

        echo json_encode($data);
    }
}
