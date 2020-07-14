<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Stockslib
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function get_available_stocks()
    {
        $stocks = array(
            'atlantic_endeavours' => array(
                'name' => 'Atlantic Endeavours',
                'link' => base_url('bank/buy_stock/atlantic_endeavours'),
                'description' => 'A safe and sound investment. Focuses on trading silk and sugar.',
                'cost' => 1000,
                'volatility' => 2
            ),
            'hispaniola_trading' => array(
                'name' => 'Hispaniola Trading',
                'link' => base_url('bank/buy_stock/hispaniola_trading'),
                'description' => 'Medium risk stock that focuses on trading tobacco and rum.',
                'cost' => 5000,
                'volatility' => 4
            ),
            'ships_and_sails_federation' => array(
                'name' => 'Ships and Sails Federation',
                'link' => base_url('bank/buy_stock/ships_and_sails_federation'),
                'description' => 'High risk investment. Focuses on new ship building techniques.',
                'cost' => 10000,
                'volatility' => 6
            )
        );

        return $stocks;
    }

    public function update_stocks_worth($stocks)
    {
        if (count($stocks) <= 0) {
            // Nothing to do here
            return;
        }

        foreach ($stocks as $stock_id => $stock) {
            $worth_change = $stock['worth'] * ($stock['volatility'] / 100);

            if (random_int(1, 10) >= 5) {
                // Gains
                $new_worth = floor($stock['worth'] + $worth_change);
            } else {
                // Loss
                $new_worth = floor($stock['worth'] - $worth_change);
            }

            $stock['worth'] = $new_worth > 0 ? $new_worth : 0;
            $updates['stocks'][$stock_id] = $stock;
        }

        return $this->CI->Game->update($updates);
    }
}
