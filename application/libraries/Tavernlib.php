<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tavernlib
{
    public function get_items($game)
    {
        require_once(__DIR__ . "/../constants/tavern.php");

        $items = array(
            array(
                'id' => 'dinner',
                'name' => 'Dinner',
                'image' => base_url('assets/images/tavern/tavern-dinner.png'),
                'description' => 'Increases your crew members health by +25 and their mood by +3.',
                'price_buy' => constant('DINNER_BUY_PRICE') * ($game['crew_members'] + 1),
                'link' => base_url('tavern/buy_post/dinner'),
                'health_increase' => 25,
                'mood_increase' => 3
            ),
            array(
                'id' => 'tobacco',
                'name' => 'Tobacco',
                'image' => base_url('assets/images/tavern/tavern-tobacco.png'),
                'description' => 'Increases your crew members mood by +5.',
                'price_buy' => constant('TOBACCO_BUY_PRICE') * ($game['crew_members'] + 1),
                'link' => base_url('tavern/buy_post/tobacco'),
                'health_increase' => 0,
                'mood_increase' => 5
            ),
            array(
                'id' => 'wine',
                'name' => 'Wine',
                'image' => base_url('assets/images/tavern/tavern-wine.png'),
                'description' => 'Increases your crew members mood by +7.',
                'price_buy' => constant('WINE_BUY_PRICE') * ($game['crew_members'] + 1),
                'link' => base_url('tavern/buy_post/wine'),
                'health_increase' => 0,
                'mood_increase' => 7
            ),
            array(
                'id' => 'rum',
                'name' => 'Rum',
                'image' => base_url('assets/images/tavern/tavern-rum.png'),
                'description' => 'Increases your crew members mood by +10.',
                'price_buy' => constant('RUM_BUY_PRICE') * ($game['crew_members'] + 1),
                'link' => base_url('tavern/buy_post/rum'),
                'health_increase' => 0,
                'mood_increase' => 10
            ),
        );

        return $items;
    }

    public function get_sailors_number_meet($crew_members)
    {
        if ($crew_members <= 0) {
            return 1;
        }

        if ($crew_members <= 10) {
            return round($crew_members * (rand(10, 25) / 100));
        }
        
        if ($crew_members <= 20) {
            return round($crew_members * (rand(8, 15) / 100));
        }
        
        return round($crew_members * (rand(4, 10) / 100));
    }

    public function get_sailors_action()
    {
        require_once(__DIR__ . "/../constants/tavern.php");

        $action = random_int(1, 10);

        if ($action >= SAILORS_FIGHT_AND_YOU_LOOSE_CHANCE_MIN) {
            return 'SAILORS_ACTION_FIGHT_YOU_LOOSE';
        }

        if ($action >= SAILORS_FIGHT_AND_YOU_WIN_CHANCE_MIN) {
            return 'SAILORS_ACTION_FIGHT_YOU_WIN';
        }

        return 'SAILORS_ACTION_JOIN';
    }

    public function get_sailors_win_loot($sailors)
    {
        require_once(__DIR__ . "/../constants/tavern.php");

        return $sailors * random_int(SAILORS_WIN_LOOT_MIN, SAILORS_WIN_LOOT_MAX);
    }

    public function get_sailors_loose_health_decrease()
    {
        require_once(__DIR__ . "/../constants/tavern.php");

        return 0 - random_int(SAILORS_LOOSE_HEALTH_DECREASE_MIN, SAILORS_LOOSE_HEALTH_DECREASE_MAX);
    }

    public function get_gamble_result($bet)
    {
        require_once(__DIR__ . "/../constants/tavern.php");

        $result = random_int(1, 40);

        if ($result === GAMBLE_WIN_JACKPOT_CHANCE) {
            $profit = floor($bet * GAMBLE_WIN_JACKPOT_PROFIT);

            return array('GAMBLE_WIN_JACKPOT', $profit);
        }

        if ($result <= GAMBLE_WIN_CHANCE) {
            $profit = floor($bet * random_int(GAMBLE_WIN_MIN_PROFIT, GAMBLE_WIN_MAX_PROFIT));

            return array('GAMBLE_WIN', $profit);
        }

        return array('GAMBLE_LOOSE', 0);
    }
}
