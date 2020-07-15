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

    public function stocks()
    {
        $this->load->library('Stockslib');

        $this->data['viewdata']['items'] = $this->stockslib->get_available_stocks();

        $this->load->view_ajax('bank/view_stocks', $this->data);
    }

    public function buy_stock()
    {
        $this->load->library('Stockslib');

        $wanted_stock_name_id = $this->uri->segment(3);
        $stocks = $this->stockslib->get_available_stocks();

        if (!isset($stocks[$wanted_stock_name_id])) {
            $data['error'] = 'This stock is not available.';
            echo json_encode($data);
            return;
        }

        $stock = $stocks[$wanted_stock_name_id];

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

        $new_stock_id = uniqid();

        $new_stock = array(
            'name_id' => $wanted_stock_name_id,
            'name' => $stock['name'],
            'cost' => $stock['cost'],
            'worth' => floor($stock['cost'] * 0.98),
            'volatility' => $stock['volatility'],
            'week' => $this->data['game']['week']
        );

        $this->data['game']['stocks'][$new_stock_id] = $new_stock;
        $changes['stocks'][$new_stock_id] = $new_stock;
        $changes['doubloons'] = $this->data['game']['doubloons'] - $stock['cost'];
        $result = $this->Game->update($changes);

        if (isset($result['error'])) {
            $data['error'] = 'You could not buy this stock. ' . $result['error'] . '.';
            echo json_encode($data);
            return;
        }

        $log_input['entry'] = 'bought a stock in ' . $stock['name'] . '.';
        $this->Log->create($log_input);

        $this->data['viewdata']['items'] = $stocks;

        $data['changeElements'] = $result['changeElements'];
        $data['loadView'] = $this->load->view('bank/view_stocks', $this->data, true);
        $data['success'] = 'You bought a stock in ' . $stock['name'] . '.';
        $data['event'] = 'bank-stocks';

        echo json_encode($data);
    }

    public function sell_stock()
    {
        $this->load->library('Stockslib');

        $stock_id = $this->uri->segment(3);

        if (!isset($this->data['game']['stocks'][$stock_id])) {
            $data['error'] = 'This stock is not available.';
            echo json_encode($data);
            return;
        }

        $stock = $this->data['game']['stocks'][$stock_id];

        $changes['stocks'][$stock_id]['remove'] = true;
        $changes['doubloons'] = $this->data['game']['doubloons'] + $stock['worth'];
        $result = $this->Game->update($changes);

        unset($this->data['game']['stocks'][$stock_id]);

        if (isset($result['error'])) {
            $data['error'] = 'You could not sell this stock. ' . $result['error'] . '.';
            echo json_encode($data);
            return;
        }


        $log_input['entry'] = 'sold a stock ' . $stock['name'] . '.';
        $this->Log->create($log_input);

        $stocks = $this->stockslib->get_available_stocks();
        $this->data['viewdata']['items'] = $stocks;

        $data['changeElements'] = $result['changeElements'];
        $data['loadView'] = $this->load->view('bank/view_stocks', $this->data, true);
        $data['success'] = 'You sold your stock ' . $stock['name'] . '.';
        $data['event'] = 'bank-stocks';

        echo json_encode($data);
    }

    public function update_stocks_worth()
    {
        $this->load->library('Stockslib');
        $result = $this->stockslib->update_stocks_worth($this->data['game']['stocks']);
        
        $stocks = $this->stockslib->get_available_stocks();
        $this->data['viewdata']['items'] = $stocks;

        $data['changeElements'] = $result['changeElements'];
        $data['success'] = 'Updated stock worth.';
        $data['loadView'] = $this->load->view('bank/view_stocks', $this->data, true);
        $data['event'] = 'bank-stocks';

        echo json_encode($data);
    }
}
