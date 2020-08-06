<?php

include('Main.php');

class Shipyard extends Main
{
    public function __construct()
    {
        parent::__construct();
        
        $this_place = 'shipyard';

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
        $this->data['prices'] = $this->config->item('prices');
        $this->data['ship_specs'] = $this->config->item('ship_types');

        $this->load->view_ajax('shipyard/view_shipyard', $this->data);
    }

    public function buy_ship()
    {
        $ship_type = $this->uri->segment(3);
        $data['changeElements'] = array();
        $ship_costs = $this->config->item('prices');

        if ($ship_type == "" || ! array_key_exists($ship_type, $ship_costs)) {
            $data['error'] = 'This is not a valid ship type!';
        } else {
            $cost = $ship_costs[$ship_type]['buy'];
            $title_input['title'] = $this->data['game']['title'];
            $title_info = $this->gamelib->get_title($title_input);

            if ($cost > $this->data['game']['doubloons']) {
                $data['error'] = 'You don\'t have enough money!';
            } elseif (($this->data['game']['ships'] + 1) > $title_info['max_ships']) {
                $data['error'] = 'As a ' . $title_info['title'] . ' you cannot own more than ' . $title_info['max_ships'] . ' ships at a time...';
            } else {
                $updates['user_id'] = $this->data['user']['id'];
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = floor($cost);
                $result = $this->Game->update($updates);
                
                if (isset($result['doubloons']['success'])) {
                    $data['changeElements'] = $result['changeElements'];
                }
                
                $ship_input['user_id'] = $this->data['user']['id'];
                $ship_input['ship_type'] = $ship_type;
                $ship_output = $this->Ship->create($ship_input);
                
                if (isset($ship_output['success'])) {
                    $data['success'] = 'You bought a new ' . $ship_output['created_ship']['type'] . '!';
                    $data['changeElements'] = array_merge($data['changeElements'], $ship_output['changeElements']);
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'coins';
                    }
                    
                    $log_input['entry'] = 'bought a new ' . $ship_output['created_ship']['type'] . '.';
                    $log_input['type'] = 'transaction';
                    $this->Log->create($log_input);
                } else {
                    $data['error'] = 'Something went wrong when creating the ship!';
                }
            }
        }

        echo json_encode($data);
    }

    public function sell()
    {
        $this->data['prices'] = $this->config->item('prices');
        
        $this->load->view_ajax('shipyard/view_sell', $this->data);
    }

    public function sell_ship()
    {
        $ship_id = $this->uri->segment(3);
        $ship_costs = array('brig' => 750, 'merchantman' => 500, 'galleon' => 2000, 'frigate' => 5000);

        if (! isset($this->data['ship'][$ship_id])) {
            $data['error'] = 'You can only sell your own ships!';
        } else {
            $cost = $ship_costs[$this->data['ship'][$ship_id]['type']];

            $updates['user_id'] = $this->data['user']['id'];
            $updates['doubloons']['add'] = true;
            $updates['doubloons']['value'] = floor($cost);
            $result = $this->Game->update($updates);
            
            if (isset($result['doubloons']['success'])) {
                $data['changeElements'] = $result['changeElements'];
            }
            
            $data['changeElements']['ship_' . $ship_id]['remove'] = true;
            
            $ship_input['id'] = $ship_id;
            $ship_output = $this->Ship->erase($ship_input);
            
            if ($ship_output['success']) {
                $data['success'] = 'You sold ' . $this->data['ship'][$ship_id]['name'] . ' for ' . $cost . ' dbl!';
                $data['changeElements'] = array_merge($data['changeElements'], $ship_output['changeElements']);

                if ($this->data['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'coins';
                }
                
                $log_input['entry'] = 'sold the ship ' . $this->data['ship'][$ship_id]['name'] . ' for ' . $cost . ' dbl.';
                $log_input['type'] = 'transaction';
                $this->Log->create($log_input);
            } else {
                $data['error'] = 'Something went wrong when deleting the ship!';
            }
        }

        echo json_encode($data);
    }

    private function get_repair_all_cost($repair_cost)
    {
        $cost = 0;

        foreach ($this->data['ship'] as $ship) {
            $cost += (100 - $ship['health']) * $repair_cost;
        }

        return $cost;
    }

    public function repair()
    {
        $this->data['viewdata']['prices'] = $this->config->item('prices');
        $this->data['viewdata']['repair_all_cost'] = $this->get_repair_all_cost($this->data['viewdata']['prices']['ship_repair']['buy']);
    
        $this->load->view_ajax('shipyard/view_repair', $this->data);
    }

    public function repair_all()
    {
        $prices = $this->config->item('prices');
        $cost = $this->get_repair_all_cost($prices['ship_repair']['buy']);

        if ($cost > $this->data['game']['doubloons']) {
            $data['error'] = 'You cannot afford to repair all ships.';
            echo json_encode($data);
            return;
        }

        foreach ($this->data['ship'] as $ship) {
            $ship_updates[$ship['id']]['health'] = 100;
            $this->data['ship'][$ship['id']]['health'] = 100;
        }

        $ship_output = $this->Ship->update($ship_updates);
        
        if (!isset($ship_output['success'])) {
            $data['error'] = 'Something went wrong when trying to repair your ships.';
            echo json_encode($data);
            return;
        }
        
        $data['changeElements'] = $ship_output['changeElements'];

        $game_updates['user_id'] = $this->data['user']['id'];
        $game_updates['doubloons']['sub'] = true;
        $game_updates['doubloons']['value'] = floor($cost);
        $game_result = $this->Game->update($game_updates);

        if (isset($game_result['doubloons']['success'])) {
            $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
        }

        $this->data['game']['ship_health_lowest'] = $ship_output['new_lowest_health'];

        $this->data['viewdata']['prices'] = $this->config->item('prices');
        $this->data['viewdata']['repair_all_cost'] = $this->get_repair_all_cost($this->data['viewdata']['prices']['ship_repair']['buy']);
        $data['loadView'] = $this->load->view('shipyard/view_repair', $this->data, true);

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'hammering';
        }
        
        $log_input['entry'] = 'repaired all ships for ' . $cost . ' dbl.';
        $log_input['type'] = 'transaction';
        $this->Log->create($log_input);

        echo json_encode($data);
    }

    public function repair_ship()
    {
        $ship_id = $this->uri->segment(3);
        $prices = $this->config->item('prices');
        $cost = (100 - $this->data['ship'][$ship_id]['health']) * $prices['ship_repair']['buy'];

        if (! isset($this->data['ship'][$ship_id])) {
            $data['error'] = 'You can only repair your own ships!';
        } elseif ($cost > $this->data['game']['doubloons']) {
            $data['error'] = 'You don\'t have that much money!';
        } elseif ($cost < 1) {
            $data['error'] = 'That ship does need repair!';
        } else {
            $data['changeElements']['ship_' . $ship_id]['remove'] = true;

            $updates['user_id'] = $this->data['user']['id'];
            $updates['doubloons']['sub'] = true;
            $updates['doubloons']['value'] = floor($cost);
            $result = $this->Game->update($updates);
            
            if (isset($result['doubloons']['success'])) {
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
            }

            $updates[$ship_id]['health'] = 100;

            $ship_output = $this->Ship->update($updates);
            $data['changeElements'] = array_merge($data['changeElements'], $ship_output['changeElements']);
            
            if ($ship_output['success']) {
                $data['success'] = 'You repaired ' . $this->data['ship'][$ship_id]['name'] . ' for ' . $cost . ' dbl!';

                $this->data['ship'][$ship_id]['health'] = 100;
                $this->data['game']['ship_health_lowest'] = $ship_output['new_lowest_health'];

                $this->data['viewdata']['prices'] = $this->config->item('prices');
                $this->data['viewdata']['repair_all_cost'] = $this->get_repair_all_cost($this->data['viewdata']['prices']['ship_repair']['buy']);
                $data['loadView'] = $this->load->view('shipyard/view_repair', $this->data, true);

                if ($this->data['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'hammering';
                }
                
                $log_input['entry'] = 'repaired the ship ' . $this->data['ship'][$ship_id]['name'] . ' for ' . $cost . ' dbl.';
                $log_input['type'] = 'transaction';
                $this->Log->create($log_input);
            } else {
                $data['error'] = 'Something went wrong when repairing the ship!';
            }
        }

        echo json_encode($data);
    }

    public function fixings_post()
    {
        $items = array('cannons' => 300, 'rafts' => 200);
        $total_cost = 0;

        foreach ($items as $item => $cost) {
            $new_quantity = $this->input->post($item . '_new_quantity');
            $current_quantity = $this->data['game'][$item];
            
            if ($new_quantity >= 0) {
                if ($new_quantity != $this->data['game'][$item]) {
                    $total_cost += ($new_quantity > $current_quantity) ? (($new_quantity - $current_quantity) * $cost) : ((0 - ($current_quantity - $new_quantity)) * floor($cost * 0.7));
                    $updates[$item]['value'] = $new_quantity;
                    $this->data['game'][$item] = $new_quantity;
                    $data['changeElements']['inventory_' . $item]['text'] = $new_quantity;
                    $msg_list[] = ($new_quantity > $current_quantity) ? ' Bought ' . ($new_quantity - $current_quantity) . ' ' . $item : ' Sold ' . ($current_quantity - $new_quantity) . ' ' . $item;
                }
            }
        }

        if (($this->data['game']['doubloons'] - floor($total_cost)) < 0) {
            $data['error'] = 'You don\'t have enough money!';
        } elseif (! isset($msg_list)) {
            $data['info'] = 'No changes made.';
        } else {
            $msg_list = $this->gamelib->readable_list($msg_list);
            $data['success'] = 'You ' . $msg_list;
        
            $updates['doubloons']['sub'] = true;
            $updates['doubloons']['value'] = floor($total_cost);
            $result = $this->Game->update($updates);
            
            if (isset($result['doubloons']['success'])) {
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                
                if ($this->data['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'coins';
                }
            }

            $log_input['entry'] = $msg_list . '.';
            $log_input['type'] = 'transaction';
            $this->Log->create($log_input);
        }
        
        echo json_encode($data);
    }
}

/*  End of shipyard.php */
/* Location: ./application/controllers/shipyard.php */
