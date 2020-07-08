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
        $form_rules['character_avatar'] 		= array('name' => 'Character avatar', 'min_length' => 3);
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
            
            list($gender, $avatar) = explode("###", $this->input->post('character_avatar'));
            $game_input['character_avatar'] = $avatar;

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
    
    public function settings_account()
    {
        if ($this->data['user']['verified'] == 1) {
            //Settings for the account
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

            $this->data['viewdata']['profile_picture'] = file_exists(APPPATH . '../assets/images/profile_pictures/' . $this->data['user']['id'] . '.jpg')
                ? base_url('assets/images/profile_pictures/' . $this->data['user']['id'] . '.jpg')
                : base_url('assets/images/profile_pictures/nopic.jpg');
                        
            $this->load->view_ajax('account/view_account', $this->data);
        }
    }
    
    public function settings_account_post()
    {
        if ($this->data['user']['verified'] == 1) {
            //Validate form data
            $form_rules['name'] 				= array('name' => 'Full name', 'min_length' => 3);
            $form_rules['gender']				= array('name' => 'Gender', 'exact_match' => array('M', 'F'));
            $form_rules['day']					= array('name' => 'Date', 'in_range' => array_fill(1, 31, true));
            $form_rules['month']				= array('name' => 'Date', 'in_range' => array_fill(1, 12, true));
            $form_rules['year']					= array('name' => 'Date', 'in_range' => array_fill(1930, 2010, true));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
            if (! $data['error']) {
                //Update the user database
                $user_input['name'] = $this->input->post('name');
                $user_input['gender'] = $this->input->post('gender');
                $user_input['birthday'] = $this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('day') . ' 12:00:00';
                $user_input['presentation'] = $this->input->post('presentation');
                $user_input['notify_new_messages'] = ($this->input->post('notify_new_messages') == 'on') ? 1 : 0;
                $user_input['show_gender'] = ($this->input->post('show_gender') == 'on') ? 1 : 0;
                $user_input['show_age'] = ($this->input->post('show_age') == 'on') ? 1 : 0;
                
                $data['success'] = 'Successfully updated your settings.';
                
                $this->User->update('id', $this->data['user']['id'], $user_input);
            }
            
            echo json_encode($data);
        }
    }
    
    public function upload_profile_picture()
    {
        //Get the image through AJAX
        $contents = file_get_contents('php://input');
        
        if ($contents) {
            //Save temporary uploaded file to right place
            $filename = APPPATH . '../assets/images/profile_pictures/' . $this->data['user']['id'] . '.jpg';
            $thumbname = APPPATH . '../assets/images/profile_pictures/' . $this->data['user']['id'] . '_thumb.jpg';
            file_put_contents($filename, $contents);
            
            //Resize the image
            $config['image_library'] = 'gd2';
            $config['source_image']	= $filename;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['width'] = 120;
            $config['height'] = 120;
            $config['quality'] = 75;

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            
            //Make thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image']	= $filename;
            $config['new_image'] = $thumbname;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['width'] = 40;
            $config['height'] = 40;
            $config['quality'] = 75;
            
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            
            $data['manipulateDom']['success'] = 'Successfully uploaded profile picture.';
        } else {
            $data['manipulateDom']['error'] = 'Could not upload profile picture';
        }
        
        echo json_encode($data);
    }
    
    public function settings_email()
    {
        if ($this->data['user']['verified'] == 1) {
            //Settings for the password
            $this->load->view_ajax('account/view_email', $this->data);
        }
    }
    
    public function send_email_verification()
    {
        //Change a users email/login
        $form_rules['new_email']		= array('name' => 'New email', 'email' => true);
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);

        if ($this->data['user']['email'] != $this->input->post('new_email')) {
            if ($this->User->user_exists($this->input->post('new_email'))) {
                $data['error'] = 'This email address is already registered. If it is yours, you can logout and reset your password.
								  You will then lose this game data and retrieve your old data for that user.';
            }

            if (! $data['error']) {
                //The new email are ok, mail a verification link
                $email_pin = uniqid();
                $verification = base_url('account/email_change/' . $email_pin);
                $message = "You have choosen to change email adress in " . $this->config->item('site_name') . " to {$this->input->post('new_email')}. Click the link below to verify this.\n\n{$verification}";
                
                $this->load->library('email');
                $this->email->from($this->config->item('email'), $this->config->item('site_name'));
                $this->email->to($this->input->post('new_email'));
                $this->email->subject('Email adress change');
                $this->email->message($message);
                $this->email->send();

                //Write in database the email the user want's to change too
                $user_updates['new_email'] = $this->input->post('new_email');
                $user_updates['email_pin'] = $email_pin;
                $this->User->update('id', $this->data['user']['id'], $user_updates);
                
                $data['success'] = 'An verification link has been sent to ' . $this->input->post('new_email') . '.';
            }
        }

        echo json_encode($data);
    }

    public function email_change()
    {
        $user = $this->User->get('email_pin', $this->uri->segment(3), 'id, new_email');

        if ($user) {
            $user_data['email'] = $user['new_email'];
            $user_data['new_email'] = '';
            $user_data['email_pin'] = '';
            $this->User->update('id', $user['id'], $user_data);

            $data['header'] = 'Success';
            $data['message'] = 'The email adress change was successfully changed to ' . $user['new_email'] . '. You have to ' . anchor('/', 'Log in') . ' again.';
        } else {
            $data['header'] = 'Error';
            $data['message'] = 'No such user.';
        }
        
        $this->load->view('view_info', $data);
    }

    public function settings_character()
    {
        if ($this->data['user']['verified'] == 1) {
            //Settings for the character
            $this->load->view_ajax('account/view_character', $this->data);
        }
    }
    
    public function generate_character()
    {
        $character = $this->gamelib->generate_character();

        $data['changeElements']['character_name']['val'] = $character['character_name'];
        $data['changeElements']['character_age']['val'] = $character['character_age'];
        $data['changeElements']['character_gender']['val'] = $character['character_gender'];
        $data['changeElements']['character_avatar']['val'] = $character['character_avatar'];
        $data['changeElements']['current_avatar_img']['src'] = $character['character_avatar_path'];
        
        echo json_encode($data);
    }
    
    public function avatar_selector()
    {
        $this->data['gender'] = $this->uri->segment(3);
        $avatars = glob(APPPATH . "../assets/images/avatars/" . $this->data['gender'] . "/avatar_*.png");
        $this->data['number_of_avatars'] = count($avatars);

        $this->load->view_ajax('account/view_avatars', $this->data);
    }
    
    public function settings_character_post()
    {
        if ($this->data['user']['verified'] == 1) {
            //Change character settings
            $form_rules['character_name'] 		= array('name' => 'Character name', 'min_length' => 3);
            $form_rules['character_avatar'] 	= array('name' => 'Character avatar', 'min_length' => 3);
            $form_rules['character_gender']		= array('name' => 'Character gender', 'exact_match' => array('M', 'F'));
            $form_rules['character_age']		= array('name' => 'Character age', 'in_range' => array_fill(1, 99, true));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);

            //Check if the inputs are OK
            if (! $data['error']) {
                //Set game info for the game database
                $data['success'] = 'Successfully saved changes.';
                
                $updates['character_name'] = $this->input->post('character_name');
                $updates['character_avatar'] = $this->input->post('character_avatar');
                $updates['character_gender'] = $this->input->post('character_gender');
                $updates['character_age'] = $this->input->post('character_age');
                $updates['character_description'] = strip_tags($this->input->post('character_description'));

                if ($this->input->post('reset_game') == 'on') {
                    $home_nation_info = $this->gamelib->get_nations('random');
                    $updates['nationality'] = $home_nation_info['nation'];
                    $updates['town'] = $home_nation_info['towns'][array_rand($home_nation_info['towns'])];
                    $updates['place'] = 'dock';
                    $updates['title'] = 'pirate';
                    $updates['week'] = 1;
                    $updates['doubloons'] = 300;
                    $updates['bank_account'] = 0;
                    $updates['bank_loan'] = 0;
                    $updates['cannons'] = 2;
                    $updates['prisoners'] = 0;
                    $updates['food'] = 20;
                    $updates['water'] = 40;
                    $updates['porcelain'] = 0;
                    $updates['spices'] = 0;
                    $updates['silk'] = 0;
                    $updates['tobacco'] = 0;
                    $updates['rum'] = 0;
                    $updates['medicine'] = 0;
                    $updates['rafts'] = 1;
                    $updates['victories_england'] = 0;
                    $updates['victories_france'] = 0;
                    $updates['victories_spain'] = 0;
                    $updates['victories_holland'] = 0;
                    $updates['victories_pirates'] = 0;
                    $updates['event_ship_won'] = '';
                    $updates['event_ocean_trade'] = '';
                    $updates['event']['ship_meeting'] = null;
                    $updates['event']['cityhall_work'] = null;
                    $updates['event']['tavern_sailors'] = null;
                    $updates['event']['tavern_blackjack'] = null;
                    $updates['event']['market_goods'] = null;
                    $updates['event']['market_slaves'] = null;

                    $ship_input['user_id'] = $this->data['user']['id'];
                    $ship_input['delete_all'] = true;
                    $this->Ship->erase($ship_input);

                    $crew_input['user_id'] = $this->data['user']['id'];
                    $crew_input['delete_all'] = true;
                    $this->Crew->erase($crew_input);
                    
                    //Create a brig ship
                    $ship_data['user_id'] = $this->data['user']['id'];
                    $ship_data['type'] = 'brig';
                    $this->Ship->create($ship_data);
                    
                    //Create four crew members
                    $crew_data['user_id'] = $this->data['user']['id'];
                    $crew_data['nationality'] = $updates['nationality'];
                    $crew_data['number_of_men'] = 4;
                    $this->Crew->create($crew_data);

                    $data['success'] .= ' Your character was resetted. Good luck with your new one! You got a brig, four crew members and 300 dbl.';

                    $this->Log->erase($this->data['user']['id']);
                    
                    $this->load->model('History');
                    $this->History->erase($this->data['user']['id']);
                    
                    $log_input['entry'] = 'resetted the account. A new brig is crafted, four crew members joins and brings 300 dbl.';
                    $log_input['week'] = 1;
                    $this->Log->create($log_input);
                    
                    $data['reloadPage'] = true;
                }

                //Update the game database
                $result = $this->Game->update($updates);
                $data['changeElements'] = $result['changeElements'];
            }
            
            echo json_encode($data);
        }
    }
    
    public function settings_password()
    {
        if ($this->data['user']['verified'] == 1) {
            //Settings for the password
            $this->load->view_ajax('account/view_password', $this->data);
        }
    }
    
    public function settings_password_post()
    {
        //Change a users password from settings
        if ($this->data['user']['verified'] == 1) {
            //Change character settings
            $form_rules['new_password']			= array('name' => 'New password', 'min_length' => 6);
            $form_rules['repeated_new_password']= array('name' => 'Repeated new password', 'exact_match' => array($this->input->post('new_password')));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
            if (md5($this->input->post('old_password')) !== $this->data['user']['password']) {
                $data['error'] = '* <em>Old password</em> did not match your current password';
            }

            if (! $data['error']) {
                //Set info for the database
                $user_input['password'] = md5($this->input->post('new_password'));
                
                //Update users with the new info
                $this->User->update('id', $this->data['user']['id'], $user_input);
                
                $this->session->set_userdata('password', $this->input->post('new_password'));

                $data['success'] = 'Your password has been changed!';
            }
            
            echo json_encode($data);
        }
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

    public function password_send_reset_link()
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
            $data['error'] = 'There is no user that is using that email address.';
        }

        if (! $data['error']) {
            $password_pin = uniqid();
            $verification = base_url('account/password_reset/' . $password_pin);
            $message = "You have choosen to reset your password in " . $this->config->item('site_name') . ". Click the link below to verify this.\n\n{$verification}";

            $this->load->library('email');
            $this->email->from($this->config->item('email'), $this->config->item('site_name'));
            $this->email->to($this->input->post('email'));
            $this->email->subject('Reset your password');
            $this->email->message($message);
            $this->email->send();

            //Write in database the PIN to match the user
            $user_updates['password_pin'] = $password_pin;
            $this->User->update('email', $this->input->post('login_email'), $user_updates);

            $data['success'] = 'A verification link has been sent to ' . $this->input->post('email') . '.';
        }
        
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
    
    public function password_change()
    {
        //Actual password change
        $form_rules['new_password']			= array('name' => 'New password', 'min_length' => 6);
        $form_rules['repeated_new_password']= array('name' => 'Repeated new password', 'exact_match' => array($this->input->post('new_password')));
        
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
        
        if (! $data['error']) {
            $user_data['password'] = md5($this->input->post('new_password'));
            $user_data['password_pin'] = '';
            $this->User->update('password_pin', $this->input->post('verification'), $user_data);
            
            $data['success'] = 'Your password has been changed!';
        }
        
        echo json_encode($data);
    }

    public function music()
    {
        $value = $this->uri->segment(3);
        $this->User->update('id', $this->data['user']['id'], array('music_play' => $value));
    }

    public function music_volume()
    {
        $volume = $this->uri->segment(3);
        $this->User->update('id', $this->data['user']['id'], array('music_volume' => $volume));
    }
    
    public function sound_effects()
    {
        $value = $this->uri->segment(3);
        $this->User->update('id', $this->data['user']['id'], array('sound_effects_play' => $value));
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

/* End of file account.php */
/* Location: ./application/controllers/account.php */
