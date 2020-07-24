<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Blackjacklib
{
    public function __construct()
    {
        require_once(__DIR__ . '/../constants/blackjack.php');
    }

    public function get_card_suite($suite_id)
    {
        if (strlen($suite_id) > 1) {
            // Take care of H10 = H for instance
            $suite_id = substr($suite_id, 0, 1);
        }

        switch ($suite_id) {
            case 'S':
                return array('id' => $suite_id, 'name' => 'spades', 'symbol' => SPADES_SYMBOL);
            case 'H':
                return array('id' => $suite_id, 'name' => 'hearts', 'symbol' => HEARTS_SYMBOL);
            case 'D':
                return array('id' => $suite_id, 'name' => 'diamonds', 'symbol' => DIAMONDS_SYMBOL);
            case 'C':
                return array('id' => $suite_id, 'name' => 'clubs', 'symbol' => CLUBS_SYMBOL);
            default:
                return false;
        }
    }

    public function get_card_value($value)
    {
        if (strlen($value) > 1) {
            // Take care of H10 = 10 for instance
            $value = substr($value, 1);
        }

        switch ($value) {
            case 1: return 'A';
            case 11: return 'J';
            case 12: return 'Q';
            case 13: return 'K';
            default: return $value;
        }
    }

    public function get_card_total_value($cards)
    {
        $total_value = 0;

        for ($i = 0; $i < count($cards); $i++) {
            $card = $cards[$i];
            $card_value = substr($card, 1);

            if ($card_value > FACE_CARD_VALUE) {
                // Jack, queen and king are worth 10
                $card_value = FACE_CARD_VALUE;
            }

            if ($card_value == ACE_MIN_VALUE) {
                // Aces are worth 11 (or 1 - handles later)
                $card_value = ACE_MAX_VALUE;
            }

            $total_value += $card_value;
        }

        if ($total_value > BLACK_JACK_VALUE) {
            // Fat, see if any aces can be worth 1 instead
            for ($i = 0; $i < count($cards); $i++) {
                $card = $cards[$i];
                $card_value = substr($card, 1);

                if ($card_value == ACE_MIN_VALUE) {
                    // It's an ace, make it worth 1 instead
                    $total_value -= ACE_MAX_VALUE - 1;

                    if ($total_value <= BLACK_JACK_VALUE) {
                        // We are fine now...
                        continue;
                    }
                }
            }
        }

        return $total_value;
    }

    public function create_card()
    {
        $suites = array('S', 'H', 'D', 'C');
        $suite_id = $suites[random_int(0, count($suites) - 1)];

        $card_number = random_int(1, 13);

        return $suite_id . $card_number;
    }

    public function get_card($card)
    {
        $suite = $this->get_card_suite($card);
        $value = $this->get_card_value($card);

        return array(
            'suite_id' => $suite['id'],
            'suite_name' => $suite['name'],
            'suite_symbol' => $suite['symbol'],
            'value' => $value
        );
    }

    public function is_bust($value)
    {
        return $value > BLACK_JACK_VALUE;
    }

    public function get_winning_sum($bet, $cards)
    {
        $total_value = $this->get_card_total_value($cards);

        if (count($cards) === 2 && $total_value === 21) {
            // Black Jack! Two cards and it is 21
            return array(true, floor($bet * WINNING_SUM_BLACKJACK));
        }

        return array(false, floor($bet * WINNING_SUM_DEFAULT));
    }
}
