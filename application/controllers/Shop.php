<?php

include('Main.php');

class Shop extends Main
{
    public function index()
    {
        $this_place = 'shop';
        
        if ($this->data['game']['place'] !== $this_place) {
            $updates['place'] = $this_place;
            $result = $this->Game->update($updates);
        }

        $this->load->library('Shoplib');
        $this->data['viewdata']['items'] = $this->shoplib->get_items($this->data['game']);

        $this->load->view_ajax('shop/view_shop', $this->data);
    }

    public function transfer_post()
    {
        if ($this->data['game']['place'] !== 'shop') {
            return;
        }

        $output = array();
        
        $this->load->library('Shoplib');
        $items = $this->shoplib->get_items($this->data['game']);

        $total_cost = 0;
        $total_load = 0;
        $affected_items = 0;

        foreach ($items as $item) {
            $new_quantity = $this->input->post($item['id'] . '_new_quantity');
            $current_quantity = $item['value'];

            $total_load += $new_quantity;

            if ($new_quantity < 0 || $new_quantity === $current_quantity) {
                continue;
            }

            $affected_items++;

            if ($new_quantity > $current_quantity) {
                // Buy
                $total_cost += ($new_quantity - $current_quantity) * $item['price_buy'];
                $item_msg[] = ' bought ' . ($new_quantity - $current_quantity) . ' ' . $item['unit'] . ' of ' . $item['id'];
            } else {
                // Sell
                $total_cost -= ($current_quantity - $new_quantity) * $item['price_sell'];
                $item_msg[] = ' sold ' . ($current_quantity - $new_quantity) . ' ' . $item['unit'] . ' of ' . $item['id'];
            }

            $db_updates[$item['id']]['value'] = $new_quantity;

            $output['changeElements']['inventory_' . $item['id']]['text'] = $new_quantity;
            $output['changeElements'][$item['id'] . '_quantity']['val'] = $new_quantity;
        }

        if ($affected_items < 1) {
            $output['info'] = 'No changes made...';
            echo json_encode($output);
            return;
        }

        if (($this->data['game']['doubloons'] - floor($total_cost)) < 0) {
            $output['error'] = 'You don\'t have enough money!';
            unset($output['changeElements']);
            echo json_encode($output);
            return;
        }
        
        if ($this->data['game']['load_max'] < $total_load) {
            $output['error'] = 'Your ships cannot load that much!';
            unset($output['changeElements']);
            echo json_encode($output);
            return;
        }

        $doubloons_left = $this->data['game']['doubloons'] - floor($total_cost);
                
        $output['changeElements']['current_money']['val'] = $doubloons_left;
        $output['changeElements']['total_cost']['html'] = 0;
                
        $db_updates['doubloons'] = $doubloons_left;
        $db_result = $this->Game->update($db_updates);
                
        if (isset($db_result['doubloons']['success'])) {
            $output['changeElements'] = array_merge($output['changeElements'], $db_result['changeElements']);
        }
                
        if ($this->data['user']['sound_effects_play'] == 1) {
            $output['playSound'] = 'coins';
        }
                
        $output['success'] = 'You ' . $this->gamelib->readable_list($item_msg) . '.';

        $log_input['entry'] = $this->gamelib->readable_list($item_msg) . '.';
        $this->Log->create($log_input);
        
        echo json_encode($output);
    }
}
