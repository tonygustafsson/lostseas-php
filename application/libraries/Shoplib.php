<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Shoplib
{
    public function get_items($game)
    {
        require(__DIR__ . "/../constants/shop.php");

        $items = array(
            array(
                'id' => 'food',
                'name' => 'Food',
                'icon' => '#food',
                'description' => 'Needed for traveling at sea.',
                'price_buy' => constant('FOOD_BUY_PRICE'),
                'price_sell' => constant('FOOD_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['food']
            ),
            array(
                'id' => 'water',
                'name' => 'Water',
                'icon' => '#water',
                'description' => 'Needed for traveling at sea.',
                'price_buy' => constant('WATER_BUY_PRICE'),
                'price_sell' => constant('WATER_SELL_PRICE'),
                'unit' => 'barrels',
                'value' => $game['water']
            ),
            array(
                'id' => 'porcelain',
                'name' => 'Porcelain',
                'icon' => '#porcelain',
                'description' => 'For trading.',
                'price_buy' => constant('PORCELAIN_BUY_PRICE'),
                'price_sell' => constant('PORCELAIN_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['porcelain']
            ),
            array(
                'id' => 'spices',
                'name' => 'Spices',
                'icon' => '#spices',
                'description' => 'For trading.',
                'price_buy' => constant('SPICES_BUY_PRICE'),
                'price_sell' => constant('SPICES_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['spices']
            ),
            array(
                'id' => 'silk',
                'name' => 'Silk',
                'icon' => '#silk',
                'description' => 'For trading.',
                'price_buy' => constant('SILK_BUY_PRICE'),
                'price_sell' => constant('SILK_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['silk']
            ),
            array(
                'id' => 'medicine',
                'name' => 'Medicine',
                'icon' => '#medicine',
                'description' => 'Can heal individual crew members.',
                'price_buy' => constant('MEDICINE_BUY_PRICE'),
                'price_sell' => constant('MEDICINE_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['medicine']
            ),
            array(
                'id' => 'tobacco',
                'name' => 'Tobacco',
                'icon' => '#tobacco',
                'description' => 'Can increase your crew members mood.',
                'price_buy' => constant('TOBACCO_BUY_PRICE'),
                'price_sell' => constant('TOBACCO_SELL_PRICE'),
                'unit' => 'cartons',
                'value' => $game['tobacco']
            ),
            array(
                'id' => 'rum',
                'name' => 'Rum',
                'icon' => '#rum',
                'description' => 'Can increase your crew members mood.',
                'price_buy' => constant('RUM_BUY_PRICE'),
                'price_sell' => constant('RUM_SELL_PRICE'),
                'unit' => 'barrels',
                'value' => $game['rum']
            ),
        );

        return $items;
    }
}
