<?php

include('Main.php');

class Shop extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'shop';
        
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
        
        $this->load->view_ajax('shop/view_shop', $this->data);
    }

    public function transfer_post()
    {
        $data = array();
        
        $items = array('food', 'water', 'porcelain', 'spices', 'silk', 'medicine', 'tobacco', 'rum');
        $prices = $this->config->item('prices');
        $total_cost = 0;
        $total_load = 0;

        foreach ($items as $item) {
            $new_quantity = $this->input->post($item . '_new_quantity');
            $current_quantity = $this->data['game'][$item];

            if ($new_quantity >= 0) {
                if ($new_quantity != $this->data['game'][$item]) {
                    //The item is not the same as in $game
                    $total_cost += ($new_quantity > $current_quantity) ? (($new_quantity - $current_quantity) * $prices[$item]['buy']) : ((0 - ($current_quantity - $new_quantity)) * $prices[$item]['sell']);
                    $updates[$item]['value'] = $new_quantity;
                    $this->data['game'][$item] = $new_quantity;
                    $data['changeElements']['inventory_' . $item]['text'] = $new_quantity;
                    $data['changeElements'][$item . '_quantity']['val'] = $new_quantity;
                    $item_msg[] = ($new_quantity > $current_quantity) ? ' bought ' . ($new_quantity - $current_quantity) . ' cartons of ' . $item : ' sold ' . ($current_quantity - $new_quantity) . ' cartons of ' . $item;
                }

                $total_load += $new_quantity;
            }
        }

        if (($this->data['game']['doubloons'] - floor($total_cost)) < 0) {
            $data['error'] = 'You don\'t have enough money!';
            unset($data['changeElements']);
        } elseif (($this->data['game']['load_max'] - $total_load) < 0) {
            $data['error'] = 'Your ships cannot load that much!';
            unset($data['changeElements']);
        } else {
            if (isset($item_msg)) {
                $this->data['game']['doubloons'] -= floor($total_cost);
                $this->data['game']['load_current'] = $total_load;
                
                $data['changeElements']['current_money']['val'] = $this->data['game']['doubloons'];
                $data['changeElements']['total_cost']['html'] = 0;
                
                $updates['doubloons'] = $this->data['game']['doubloons'];
                $result = $this->Game->update($updates);
                
                if (isset($result['doubloons']['success'])) {
                    $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                }
                
                if ($this->data['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'coins';
                }
                
                $data['success'] = 'You ' . $this->gamelib->readable_list($item_msg) . '.';

                $log_input['entry'] = $this->gamelib->readable_list($item_msg) . '.';
                $this->Log->create($log_input);
            } else {
                $data['info'] = 'No changes made...';
            }
        }
        
        echo json_encode($data);
    }
}

/*  End of shop.php */
/* Location: ./application/controllers/shop.php */
