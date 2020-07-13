<?php

include('Main.php');

class Bank extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'bank';

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
        $this->load->view_ajax('bank/view_bank', $this->data);
    }
    
    public function account_post()
    {
        $transfer = $this->input->post('transfer');

        if ($transfer < 0 && abs($transfer) > $this->data['game']['bank_account']) {
            $data['error'] = 'You cannot take out more money than you\'ve got in your bank account!';
        } elseif ($transfer > 0 && $transfer > $this->data['game']['doubloons']) {
            $data['error'] = 'You cannot put in more money than you\'ve got in cash!';
        } elseif ($transfer == 0) {
            $data['info'] = 'You didn\'t transfer any money!';
        } else {
            $new_bank_money = 0;
            $new_money = 0;

            if ($transfer > 0) {
                //Transfer into bank account
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_account']['add'] = true;
                $updates['bank_account']['value'] = floor($transfer * 0.95);
                
                $new_bank_money = $this->data['game']['bank_account'] + floor($transfer * 0.95);
                $new_money = $this->data['game']['doubloons'] - floor($transfer);

                $data['success'] = 'You transfered ' . $transfer . ' dbl to your bank account. ' . floor($transfer * 0.05) . ' dbl were taken as tax.';
                $log_input['entry'] = 'transfered ' . $transfer . ' dbl to the bank account.';
            } else {
                //Transfer from bank account
                $transfer = abs($transfer);
                
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_account']['sub'] = true;
                $updates['bank_account']['value'] = $transfer;
                
                $new_bank_money = $this->data['game']['bank_account'] - abs($transfer);
                $new_money = $this->data['game']['doubloons'] + abs($transfer);

                $data['success'] = 'You transfered ' . $transfer . ' dbl from your bank account.';
                $log_input['entry'] = 'transfered ' . abs($transfer) . ' dbl from the bank account.';
            }
            
            $result = $this->Game->update($updates);
            
            $data['changeElements'] = $result['changeElements'];
            $data['changeElements']['current_money']['value'] = $new_money;
            $data['changeElements']['current_money_bank']['value'] = $new_bank_money;

            $data['event'] = 'bank-account-post';

            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'coins';
            }
            
            $this->Log->create($log_input);
        }

        echo json_encode($data);
    }

    public function loan()
    {
        $this->load->view_ajax('bank/view_loan', $this->data);
    }

    public function loan_post()
    {
        $transfer = $this->input->post('transfer');

        if ($transfer > 0 && ($this->data['game']['bank_loan'] + $transfer) > 10000) {
            //If the loan exceeds 10000 dbl
            $data['error'] = 'Your loan cannot exceed 10000 dbl!';
        } elseif ($transfer < 0 && abs($transfer) > $this->data['game']['bank_loan']) {
            //If the transfer is larger than the bank loan
            $data['info'] = 'You don\'t have to pay back more than you loaned for!';
        } elseif ($transfer < 0 && abs($transfer) > $this->data['game']['doubloons']) {
            //If the transfer is larger than the users cash
            $data['error'] = 'You cannot pay of more than you have in cash!';
        } elseif ($transfer == 0) {
            $data['info'] = 'You didn\'t transfer any money!';
        } else {
            $new_bank_loan = 0;
            $new_money = 0;

            if ($transfer > 0) {
                //Taking a loan
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_loan']['add'] = true;
                $updates['bank_loan']['value'] = floor($transfer * 1.15);
                
                $new_bank_loan = $this->data['game']['bank_loan'] + floor($transfer * 1.15);
                $new_money = $this->data['game']['doubloons'] + floor($transfer);

                $data['success'] = 'You took a loan of ' . $transfer . ' dbl! ' . floor($transfer * 0.15) . ' dbl were taken as intrest.';
                $input_log['entry'] = 'took a loan of ' . $transfer . ' dbl from the bank.';
            } else {
                //Paying off a loan
                $transfer = abs($transfer);
                
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_loan']['sub'] = true;
                $updates['bank_loan']['value'] = $transfer;

                $new_bank_loan = $this->data['game']['bank_loan'] - floor($transfer);
                $new_money = $this->data['game']['doubloons'] - floor($transfer);
                
                $data['success'] = 'You payed back ' . abs($transfer) . ' dbl of your loan!';
                $input_log['entry'] = 'payed back ' . abs($transfer) . ' dbl of the bank loan.';
            }
        
            $result = $this->Game->update($updates);
            
            $data['changeElements'] = $result['changeElements'];
            $data['changeElements']['current_money']['value'] = $new_money;
            $data['changeElements']['current_money_bank_loan']['value'] = $new_bank_loan;

            $data['event'] = 'bank-loan-post';

            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'coins';
            }
            
            $this->Log->create($input_log);
        }
        
        echo json_encode($data);
    }

    private function get_stocks()
    {
        return array(
            'atlantic_endeavours' => array('name' => 'Atlantic Endeavours', 'link' => base_url('bank/buy_stock/atlantic_endeavours'), 'description' => 'A safe investments. Focuses on trading silk and sugar. Volatility: +-2%', 'cost' => 1000, 'volatility' => 2),
            'hispaniola_trading' => array('name' => 'Hispaniola Trading', 'link' => base_url('bank/buy_stock/hispaniola_trading'), 'description' => 'Medium risk stock that focuses on trading tobacco and rum. Volatility: +-4%', 'cost' => 5000, 'volatility' => 4),
            'ships_and_sails_federation' => array('name' => 'Ships and Sails Federation', 'link' => base_url('bank/buy_stock/ships_and_sails_federation'), 'description' => 'High risk investments. Focuses on new ship building techniques. Volatility: +-6%', 'cost' => 10000, 'volatility' => 6)
        );
    }

    public function stocks()
    {
        $this->data['viewdata']['items'] = $this->get_stocks();

        $this->load->view_ajax('bank/view_stocks', $this->data);
    }

    public function buy_stock()
    {
        $wanted_stock_name = $this->uri->segment(3);
        $stocks =  $this->get_stocks();

        if (!isset($stocks[$wanted_stock_name])) {
            $data['error'] = 'This stock is not available.';
            echo json_encode($data);
            return;
        }

        $stock = $stocks[$wanted_stock_name];

        if ($stock['cost'] > $this->data['game']['doubloons']) {
            $data['error'] = 'You cannot afford this stock.';
            echo json_encode($data);
            return;
        }

        if (count($this->data['game']['stocks']) >= 10) {
            $data['error'] = 'You cannot own more than a total of 10 stocks.';
            echo json_encode($data);
            return;
        }

        $new_stock = array(
            'id' => uniqid(),
            'name' => $stock['name'],
            'cost' => $stock['cost'],
            'value' => $stock['cost'],
            'volatility' => $stock['volatility'],
            'week' => $this->data['game']['week']
        );

        $this->data['game']['stocks'][$new_stock['id']] = $new_stock;
        $changes['stocks'][$new_stock['id']] = $new_stock;
        $changes['doubloons'] = $this->data['game']['doubloons'] - $stock['cost'];
        $result = $this->Game->update($changes);

        if (isset($result['error'])) {
            $data['error'] = 'You could not buy this stock. ' . $result['error'] . '.';
            echo json_encode($data);
            return;
        }

        $this->data['viewdata']['items'] = $stocks;

        $data['changeElements'] = $result['changeElements'];
        $data['loadView'] = $this->load->view('bank/view_stocks', $this->data, true);
        $data['success'] = 'You bought a stock in ' . $stock['name'] . '.';
        $data['event'] = 'updated-dom';
        echo json_encode($data);
    }
}
