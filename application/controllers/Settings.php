<?php

include('Main.php');

class Settings extends Main
{
    public function account()
    {
        if ($this->data['user']['verified'] == 1) {
            // Settings for the account
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
                        
            $this->load->view_ajax('settings/view_account', $this->data);
        }
    }
    
    public function account_post()
    {
        if ($this->data['user']['verified'] == 1) {
            // Validate form data
            $form_rules['name'] 				= array('name' => 'Full name', 'min_length' => 3);
            $form_rules['gender']				= array('name' => 'Gender', 'exact_match' => array('M', 'F'));
            $form_rules['day']					= array('name' => 'Date', 'in_range' => array_fill(1, 31, true));
            $form_rules['month']				= array('name' => 'Date', 'in_range' => array_fill(1, 12, true));
            $form_rules['year']					= array('name' => 'Date', 'in_range' => array_fill(1930, 2010, true));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
            if (! $data['error']) {
                // Update the user database
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
        // Get the image through AJAX
        $contents = file_get_contents("php://input");

        if (!$contents) {
            $data['manipulateDom']['error'] = 'Could not upload profile picture';
            echo json_encode($data);
            return;
        }

        // Save temporary uploaded file to right place
        $filename = APPPATH . '../assets/images/profile_pictures/' . $this->data['user']['id'] . '.jpg';

        file_put_contents($filename, $contents);

        $exif_data = exif_read_data($filename);

        if (isset($exif_data['Orientation'])) {
            // Try to auto rotate image
            switch ($exif_data['Orientation']) {
                case 3:
                    $config['rotation_angle'] = 180;
                    break;
                case 6:
                    $config['rotation_angle'] = 270;
                    break;
                case 8:
                    $config['rotation_angle'] = 90;
                    break;
            }
        }
            
        // Resize the image
        $config['image_library'] = 'gd2';
        $config['source_image']	= $filename;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = 120;
        $config['height'] = 120;
        $config['quality'] = 70;

        $this->load->library('image_lib');

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }

        // Make thumbnail
        $thumbname = APPPATH . '../assets/images/profile_pictures/' . $this->data['user']['id'] . '_thumb.jpg';
        $this->image_lib->clear();

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
        
        echo json_encode($data);
    }
    
    public function email()
    {
        if ($this->data['user']['verified'] == 1) {
            // Settings for the password
            $this->load->view_ajax('settings/view_email', $this->data);
        }
    }
    
    public function email_post()
    {
        // Change a users email/login
        $form_rules['new_email']		= array('name' => 'New email', 'email' => true);
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);

        if ($this->data['user']['email'] != $this->input->post('new_email')) {
            if ($this->User->user_exists($this->input->post('new_email'))) {
                $data['error'] = 'This email address is already registered. If it is yours, you can logout and reset your password.
								  You will then lose this game data and retrieve your old data for that user.';
            }

            if (! $data['error']) {
                // The new email are ok, mail a verification link
                $email_pin = uniqid();
                $verification = base_url('settings/email_change/' . $email_pin);
                $message = "You have choosen to change email adress in " . $this->config->item('site_name') . " to {$this->input->post('new_email')}. Click the link below to verify this.\n\n{$verification}";
                
                $this->load->library('email');
                $this->email->from($this->config->item('email'), $this->config->item('site_name'));
                $this->email->to($this->input->post('new_email'));
                $this->email->subject('Email adress change');
                $this->email->message($message);
                $this->email->send();

                // Write in database the email the user want's to change too
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

    public function character()
    {
        if ($this->data['user']['verified'] == 1) {
            // Settings for the character
            $this->load->view_ajax('settings/view_character', $this->data);
        }
    }
    
    public function generate_character()
    {
        $character = $this->gamelib->generate_character();

        $short_gender = $character['character_gender'] === 'M' ? 'male' : 'female';

        $data['changeElements']['character_name']['val'] = $character['character_name'];
        $data['changeElements']['character_age']['val'] = $character['character_age'];
        $data['changeElements']['character_nation']['val'] = $character['character_nation'];
        $data['changeElements'][$short_gender]['checked'] = true;
        $data['changeElements']['character_avatar']['val'] = $character['character_avatar'];
        $data['changeElements']['current_avatar_img']['src'] = $character['character_avatar_path'];
        
        echo json_encode($data);
    }
    
    public function avatar_selector()
    {
        $this->data['gender'] = $this->uri->segment(3);
        $avatars = glob(APPPATH . "../assets/images/avatars/" . $this->data['gender'] . "/avatar_*.png");
        $this->data['number_of_avatars'] = count($avatars);

        $this->load->view_ajax('settings/view_avatars', $this->data);
    }
    
    public function character_post()
    {
        if ($this->data['user']['verified'] != 1) {
            return;
        }

        // Change character settings
        $form_rules['character_name'] 		= array('name' => 'Character name', 'min_length' => 3);
        $form_rules['character_avatar'] 	= array('name' => 'Character avatar', 'in_range' => array_fill(1, 40, true));
        $form_rules['character_gender']		= array('name' => 'Character gender', 'exact_match' => array('M', 'F'));
        $form_rules['character_age']		= array('name' => 'Character age', 'in_range' => array_fill(1, 99, true));
            
        $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);

        // Check if the inputs are OK
        if (! $data['error']) {
            // Set game info for the game database
            $data['success'] = 'Successfully saved changes.';
                
            $updates['character_name'] = $this->input->post('character_name');
            $updates['character_avatar'] = $this->input->post('character_avatar');
            $updates['character_gender'] = $this->input->post('character_gender');
            $updates['character_age'] = $this->input->post('character_age');
            $updates['character_description'] = strip_tags($this->input->post('character_description'));

            // Update the game database
            $result = $this->Game->update($updates);
            $data['changeElements'] = $result['changeElements'];
        }
            
        echo json_encode($data);
    }

    public function reset()
    {
        if ($this->data['user']['verified'] != 1) {
            return;
        }

        if (md5($this->input->post('password')) !== $this->data['user']['password']) {
            $data['error'] = 'This is not the correct password';
            echo json_encode($data);
            return;
        }

        $home_nation_info = $this->gamelib->get_nations('random');
        $updates['nationality'] = $home_nation_info['nation'];
        $updates['town'] = $home_nation_info['towns'][array_rand($home_nation_info['towns'])];
        $updates['place'] = 'dock';
        $updates['title'] = 'pirate';
        $updates['level'] = 0;
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
        $updates['victories'] = '';
        $updates['event']['ship_meeting'] = null;
        $updates['event']['ship_won_results'] = null;
        $updates['event']['ship_trade'] = null;
        $updates['event']['cityhall_work'] = null;
        $updates['event']['tavern_sailors'] = null;
        $updates['event']['tavern_blackjack'] = null;
        $updates['event']['market'] = null;

        // Update the game database
        $result = $this->Game->update($updates);
        $data['changeElements'] = $result['changeElements'];

        $ship_input['user_id'] = $this->data['user']['id'];
        $ship_input['delete_all'] = true;
        $this->Ship->erase($ship_input);

        $crew_input['user_id'] = $this->data['user']['id'];
        $crew_input['delete_all'] = true;
        $this->Crew->erase($crew_input);
            
        // Create a brig ship
        $ship_data['user_id'] = $this->data['user']['id'];
        $ship_data['type'] = 'brig';
        $this->Ship->create($ship_data);
            
        // Create four crew members
        $crew_data['user_id'] = $this->data['user']['id'];
        $crew_data['nationality'] = $updates['nationality'];
        $crew_data['number_of_men'] = 4;
        $this->Crew->create($crew_data);

        $data['success'] = ' Your character was resetted. Good luck with your new one! You got a brig, four crew members and 300 dbl.';

        $this->Log->erase($this->data['user']['id']);
            
        $this->load->model('History');
        $this->History->erase($this->data['user']['id']);
            
        $log_input['entry'] = 'resetted the account. A new brig is crafted, four crew members joins and brings 300 dbl.';
        $log_input['week'] = 1;
        $this->Log->create($log_input);
            
        $data['reloadPage'] = true;

        echo json_encode($data);
    }
    
    public function password()
    {
        if ($this->data['user']['verified'] == 1) {
            // Settings for the password
            $this->load->view_ajax('settings/view_password', $this->data);
        }
    }
    
    public function password_post()
    {
        // Change a users password from settings
        if ($this->data['user']['verified'] == 1) {
            // Change character settings
            $form_rules['new_password']			= array('name' => 'New password', 'min_length' => 6);
            $form_rules['repeated_new_password']= array('name' => 'Repeated new password', 'exact_match' => array($this->input->post('new_password')));
            
            $data['error'] = $this->gamelib->validate_form($this->input->post(), $form_rules);
            
            if (md5($this->input->post('old_password')) !== $this->data['user']['password']) {
                $data['error'] = '* <em>Old password</em> did not match your current password';
            }

            if (! $data['error']) {
                // Set info for the database
                $user_input['password'] = md5($this->input->post('new_password'));
                
                // Update users with the new info
                $this->User->update('id', $this->data['user']['id'], $user_input);
                
                $this->session->set_userdata('password', $this->input->post('new_password'));

                $data['success'] = 'Your password has been changed!';
            }
            
            echo json_encode($data);
        }
    }
       
    public function unregister_post()
    {
        // Really unregister...
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

    public function music()
    {
        $value = $this->uri->segment(3) === 'on' ? 1 : 0;
        $this->User->update('id', $this->data['user']['id'], array('music_play' => $value));
    }

    public function music_volume()
    {
        $volume = $this->uri->segment(3);
        $this->User->update('id', $this->data['user']['id'], array('music_volume' => $volume));
    }
    
    public function sound_effects()
    {
        $value = $this->uri->segment(3) === 'on' ? 1 : 0;
        $this->User->update('id', $this->data['user']['id'], array('sound_effects_play' => $value));
    }
}
