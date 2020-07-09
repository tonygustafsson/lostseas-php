<?php

include('Main.php');

class Account extends Main
{
    public function login()
    {
        //Login user, set cookie and redirect to start page
        $userdata['email'] = ($this->input->post('login_email')) ? $this->input->post('login_email') : 'Wrong';
        $userdata['password'] = md5($this->input->post('login_password'));
        $this->session->set_userdata($userdata);
        redirect('/');
    }

    public function logout()
    {
        //Logout user, destroy cookie and redirect to start page
        $this->session->sess_destroy();
        redirect('/');
    }
    
    public function update_activity()
    {
        //Manually updates the last activity to be able to track online users
        $game_sql = "UPDATE " . $this->db->game_table . " SET last_activity = now() WHERE user_id = '" . $this->data['user']['id'] . "'";
        $this->db->query($game_sql);
    }
    
    public function register_temp()
    {
        //Prepare info that's going into the user database
        $session_id = $this->session->userdata('user_session_id');
        
        if ($this->User->user_exists($session_id)) {
            $this->User->erase($session_id);
        }
        
        if ($this->input->post('character_description') != "") {
            //Honeypot for blocking bots
            exit;
        }
        
        $form_rules['character_name'] 			= array('name' => 'Character name', 'min_length' => 3);
        $form_rules['character_age'] 			= array('name' => 'Character age', 'in_range' => array_fill(15, 80, true));
        $form_rules['character_avatar'] 		= array('name' => 'Character avatar', 'in_range' => array_fill(1, 40, true));
        $form_rules['character_gender']			= array('name' => 'Character gender', 'exact_match' => array('M', 'F'));
        
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
        
        if (! $data['error']) {
            $user_input['id'] = $session_id;
            $user_input['created'] = date('Y-m-d H:i:s', time());
            
            $this->User->create($user_input);
            
            //Prepare info that's going into the game database
            $home_nation_info = $this->gamelib->get_nations('random');
            $game_input['nationality'] = $home_nation_info['nation'];
            $game_input['town'] = $home_nation_info['towns'][array_rand($home_nation_info['towns'])];
            $game_input['place'] = 'dock';
            $game_input['title'] = 'pirate';
            
            $game_input['user_id'] = $session_id;
            $game_input['character_name'] = $this->input->post('character_name');
            $game_input['character_age'] = $this->input->post('character_age');
            $game_input['character_gender'] = $this->input->post('character_gender');
            $game_input['character_avatar'] = $this->input->post('character_avatar');

            $this->Game->create($game_input);

            //Create a brig ship
            $ship_data['user_id'] = $session_id;
            $ship_data['type'] = 'brig';
            $this->Ship->create($ship_data);
            
            //Create four crew members
            $crew_data['user_id'] = $session_id;
            $crew_data['nationality'] = $game_input['nationality'];
            $crew_data['number_of_men'] = 4;
            $this->Crew->create($crew_data);

            $log_input['user_id'] = $session_id;
            $log_input['week'] = 1;
            $log_input['entry'] = 'decides to try this game out. Arrives at ' . ucwords($game_input['town']) . 's ' . $game_input['place'] . '.';
            $this->Log->create($log_input);

            redirect('/' . $game_input['place']);
        } else {
            echo $data['error'];
        }
    }
    
    public function register()
    {
        if ($this->data['user']['verified'] == 0) {
            //Settings for the user
            $months[1] = 'Jan';
            $months[] = 'Feb';
            $months[] = 'Mar';
            $months[] = 'Apr';
            $months[] = 'May';
            $months[] = 'Jun';
            $months[] = 'Jul';
            $months[] = 'Aug';
            $months[] = 'Sep';
            $months[] = 'Oct';
            $months[] = 'Nov';
            $months[] = 'Dec';
            $this->data['months'] = $months;

            $this->load->view_ajax('account/view_register', $this->data);
        }
    }
    
    public function register_post()
    {
        if ($this->data['user']['verified'] == 0) {
            //Validate form data
            $form_rules['email'] 				= array('name' => 'Email address', 'email' => true);
            $form_rules['password'] 			= array('name' => 'Desired password', 'min_length' => 6);
            $form_rules['repeated_password'] 	= array('name' => 'Repeated password', 'exact_match' => array($this->input->post('password')));
            $form_rules['name'] 				= array('name' => 'Full name', 'min_length' => 3);
            $form_rules['gender']				= array('name' => 'Gender', 'exact_match' => array('M', 'F'));
            $form_rules['day']					= array('name' => 'Date', 'in_range' => array_fill(1, 31, true));
            $form_rules['month']				= array('name' => 'Date', 'in_range' => array_fill(1, 12, true));
            $form_rules['year']					= array('name' => 'Date', 'in_range' => array_fill(1930, 2010, true));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
            if ($this->User->user_exists($this->input->post('email'))) {
                $data['error'] = 'This email address is already registered. If it is yours, you can logout and reset your password.
								  You will then lose this game data and retrieve your old data for that user.';
            }
        
            if (! $data['error']) {
                $user_input['email'] = $this->input->post('email');
                $user_input['name'] = $this->input->post('name');
                $user_input['gender'] = $this->input->post('gender');
                $user_input['birthday'] = $this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('day') . ' 12:00:00';
                $user_input['password'] = md5($this->input->post('password'));
                $user_input['presentation'] = $this->input->post('presentation');
                $user_input['created'] = date('Y-m-d H:i:s', time());
                
                //Set a PIN to activate the account
                $password_pin = uniqid();
                $user_input['password_pin'] = $password_pin;
                
                $this->User->update('id', $this->data['user']['id'], $user_input);
                
                //Send out an email for activation
                $verification = base_url('account/activate/' . $password_pin);
                $message = "You have registered an account at " . $this->config->item('site_name') . "! Click the link below to verify this.\n\n{$verification}";

                $this->load->library('email');
                $this->email->from($this->config->item('email'), $this->config->item('site_name'));
                $this->email->to($user_input['email']);
                $this->email->subject('Verify your account');
                $this->email->message($message);
                $this->email->send();
                
                $data['success'] = 'You have successfully created an account at ' . $this->config->item('site_name') . '! Please check your inbox at ' . $user_input['email'] . ' to activate this account to get the full game experience!';
            }
            
            echo json_encode($data);
        }
    }
    
    public function activate()
    {
        $user = $this->User->get('password_pin', $this->uri->segment(3), 'id');

        if ($user) {
            $changes['password_pin'] = '';
            $changes['verified'] = 1;
            $this->User->update('id', $user['id'], $changes);
            
            $log_input['user_id'] = $user['id'];
            $log_input['week'] = 1;
            $log_input['entry'] = 'have registered to ' . $this->config->item('site_name') . '.';
            $this->Log->create($log_input);

            $data['header'] = 'Success!';
            $data['message'] = 'Your account is now verified, and you can start playing ' . $this->config->item('site_name') . ' for real!';
            $data['reload'] = 8;
        } else {
            $data['header'] = 'Error!';
            $data['reload'] = 8;
            $data['message'] = 'No such user is registered!';
        }

        $this->load->view('view_info', $data);
    }
    
    public function unregister()
    {
        if ($this->data['user']['verified'] == 1) {
            //Unregister user
            $this->load->view_ajax('account/view_unregister', $this->data);
        }
    }
    
    public function unregister_post()
    {
        //Really unregister...
        if ($this->data['user']['verified'] == 1) {
            $data['error'] = false;
        
            if (md5($this->input->post('password')) !== $this->data['user']['password']) {
                $data['error'] = '* <em>Password</em> did not match your current password';
            }

            if (! $data['error']) {
                $this->User->erase($this->data['user']['id']);
                
                $this->session->sess_destroy();
                
                $data['pushState'] = '/';
                $data['reloadPage'] = true;
            }
            
            echo json_encode($data);
        }
    }
    
    public function password_forgotten()
    {
        //View for sending email adress link
        $this->data['character'] = $this->gamelib->generate_character();
        
        $this->data['meta_description'] = "If you have forgotten your password, you can recollect it here.";
        $this->data['meta_keywords'] = "lost password, forgotten password";
        
        $log_input['entries'] = 8;
        $this->data['log_entries'] = $this->Log->get($log_input);

        $this->load->view_ajax('view_forgotten_password', $this->data);
    }

    public function password_forgotten_post()
    {
        //Send reset link via email
        
        if ($this->input->post('name') != "") {
            //Honeypot to avoid some bots
            exit();
        }
    
        //Load form helper and library, set form validation delimiters
        $form_rules['email']		= array('name' => 'Email address', 'email' => true);
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
        
        if (! $this->User->user_exists($this->input->post('email'))) {
            // Does not exist, don't let the user know
            $data['success'] = 'A verification link has been sent to ' . $this->input->post('email') . '.';
            echo json_encode($data);
            return;
        }

        if ($data['error']) {
            echo json_encode($data);
            return;
        }

        $password_pin = uniqid();
        $verification = base_url('settings/password_reset/' . $password_pin);
        $message = "You have choosen to reset your password in " . $this->config->item('site_name') . ". Click the link below to verify this.\n\n{$verification}";

        $this->load->library('email');
        $this->email->from($this->config->item('email'), $this->config->item('site_name'));
        $this->email->to($this->input->post('email'));
        $this->email->subject('Reset your password');
        $this->email->message($message);
        
        if (!$this->email->send()) {
            $data['error'] = 'Something went wrong when trying to send the email.';
            $data['mail_debug'] = $this->email->print_debugger();
        } else {
            $data['success'] = 'A verification link has been sent to ' . $this->input->post('email') . '.';
        }

        //Write in database the PIN to match the user
        $user_updates['password_pin'] = $password_pin;
        $this->User->update('email', $this->input->post('login_email'), $user_updates);

        echo json_encode($data);
    }
    
    public function password_reset()
    {
        //View for resetting the password to something that can be rememberd
        $user = $this->User->get('password_pin', $this->uri->segment(3), 'id');

        if ($user) {
            $data['verification'] = $this->uri->segment(3);
            $this->load->view_ajax('view_reset_password', $data);
        } else {
            $data['header'] = 'Error';
            $data['message'] = 'No such user.';
            $this->load->view('view_info', $data);
        }
    }
        
    public function erase_temp_users()
    {
        $erased_users = $this->User->erase_temp_users();
        
        $data['success'] = 'Deleted ' . $erased_users . ' users.';
        echo json_encode($data);
    }
    
    public function logged_out()
    {
        $log_input['entries'] = 8;
        $this->data['log_entries'] = $this->Log->get($log_input);
    
        $this->load->view_ajax('view_logged_out', $this->data);
    }
}
