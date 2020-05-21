<?php

include('Main.php');

class Bank extends Main
{
    public function __construct()
    {
        parent::__construct();

        $this_place = 'bank';

        if ($this->user['game']['place'] != $this_place) {
            $updates['place'] = $this_place;
            $result = $this->Game->update($updates);
            
            if (! isset($result['error'])) {
                $this->user['game']['place'] = $this_place;
            }
        }
    }

    public function index()
    {
        $data['runJS'] = 'window.runBank()';
        $this->user['json'] = json_encode($data);

        $this->load->view_ajax('bank/view_bank', $this->user);
    }
    
    public function account_post()
    {
        $transfer = $this->input->post('transfer');

        if ($transfer < 0 && abs($transfer) > $this->user['game']['bank_account']) {
            $data['error'] = 'You cannot take out more money than you\'ve got in your bank account!';
        } elseif ($transfer > 0 && $transfer > $this->user['game']['doubloons']) {
            $data['error'] = 'You cannot put in more money than you\'ve got in cash!';
        } elseif ($transfer == 0) {
            $data['info'] = 'You didn\'t transfer any money!';
        } else {
            if ($transfer > 0) {
                //Transfer into bank account
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_account']['add'] = true;
                $updates['bank_account']['value'] = floor($transfer * 0.95);
                
                $data['success'] = 'You transfered ' . $transfer . ' dbl to your bank account. ' . floor($transfer * 0.05) . ' dbl were taken as tax.';
                $log_input['entry'] = 'transfered ' . $transfer . ' dbl to the bank account.';
                
                $data['runJS'] = '$("#account-slider").slider("option", "min", ' . round(0 - floor($this->user['game']['bank_account'] + floor($transfer * 0.95))) . '); $("#account-slider").slider("option", "max", ' . floor($this->user['game']['doubloons'] - $transfer) . ');';
            } else {
                //Transfer from bank account
                $transfer = abs($transfer);
                
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_account']['sub'] = true;
                $updates['bank_account']['value'] = $transfer;
                
                $data['success'] = 'You transfered ' . $transfer . ' dbl from your bank account.';
                $log_input['entry'] = 'transfered ' . abs($transfer) . ' dbl from the bank account.';
                
                $data['runJS'] = '$("#account-slider").slider("option", "min", ' . round(0 - floor($this->user['game']['bank_account'] - $transfer)) . '); $("#account-slider").slider("option", "max", ' . floor($this->user['game']['doubloons'] + $transfer) . ');';
            }
            
            $result = $this->Game->update($updates);
            
            $data['changeElements'] = $result['changeElements'];
            
            if ($this->user['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'coins';
            }
            
            $this->Log->create($log_input);
        }

        echo json_encode($data);
    }

    public function loan()
    {
        $data['runJS'] = 'window.runBank()';
        $this->user['json'] = json_encode($data);
        
        $this->load->view_ajax('bank/view_loan', $this->user);
    }

    public function loan_post()
    {
        $transfer = $this->input->post('transfer');

        if ($transfer > 0 && ($this->user['game']['bank_loan'] + $transfer) > 10000) {
            //If the loan exceeds 10000 dbl
            $data['error'] = 'Your loan cannot exceed 10000 dbl!';
        } elseif ($transfer < 0 && abs($transfer) > $this->user['game']['bank_loan']) {
            //If the transfer is larger than the bank loan
            $data['info'] = 'You don\'t have to pay back more than you loaned for!';
        } elseif ($transfer < 0 && abs($transfer) > $this->user['game']['doubloons']) {
            //If the transfer is larger than the users cash
            $data['error'] = 'You cannot pay of more than you have in cash!';
        } elseif ($transfer == 0) {
            $data['info'] = 'You didn\'t transfer any money!';
        } else {
            if ($transfer > 0) {
                //Taking a loan
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_loan']['add'] = true;
                $updates['bank_loan']['value'] = floor($transfer * 1.15);
                
                $data['success'] = 'You took a loan of ' . $transfer . ' dbl! ' . floor($transfer * 0.15) . ' dbl were taken as intrest.';
                $input_log['entry'] = 'took a loan of ' . $transfer . ' dbl from the bank.';
                $data['runJS'] = '$("#loan-slider").slider("option", "min", ' . round(0 - floor($this->user['game']['bank_loan'] + floor($transfer * 1.15))) . '); $("#account-slider").slider("option", "max", ' . floor($this->user['game']['doubloons'] - $transfer) . ');';
            } else {
                //Paying off a loan
                $transfer = abs($transfer);
                
                $updates['doubloons']['sub'] = true;
                $updates['doubloons']['value'] = $transfer;
                $updates['bank_loan']['sub'] = true;
                $updates['bank_loan']['value'] = $transfer;
                
                $data['success'] = 'You payed back ' . abs($transfer) . ' dbl of your loan!';
                $input_log['entry'] = 'payed back ' . abs($transfer) . ' dbl of the bank loan.';
                $data['runJS'] = '$("#loan-slider").slider("option", "min", ' . round(0 - floor($this->user['game']['bank_loan'] - $transfer)) . '); $("#account-slider").slider("option", "max", ' . floor($this->user['game']['doubloons'] + $transfer) . ');';
            }
        
            $result = $this->Game->update($updates);
            
            $data['changeElements'] = $result['changeElements'];
            
            if ($this->user['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'coins';
            }
            
            $this->Log->create($input_log);
        }
        
        echo json_encode($data);
    }
}

/*  End of bank.php */
/* Location: ./application/controllers/bank.php */
