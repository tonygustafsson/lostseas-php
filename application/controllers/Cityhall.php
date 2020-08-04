<?php

include('Main.php');

class Cityhall extends Main
{
    public function index()
    {
        $this_place = 'cityhall';
        
        if ($this->data['game']['place'] != $this_place) {
            $updates['place'] = $this_place;
            $this->Game->update($updates);

            if (!isset($result['error'])) {
                $this->data['game']['place'] = $this_place;
            }
        }

        $this->load->view_ajax('cityhall/view_cityhall', $this->data);
    }

    public function governor()
    {
        if ($this->data['game']['place'] !== 'cityhall') {
            return;
        }

        $town_victories = $this->data['game']['victories'][$this->data['game']['nation']];
        $enemy_victories = $this->data['game']['victories'][$this->data['game']['towns_enemy']];

        if ($this->data['game']['nationality'] == $this->data['game']['nation']) {
            // The users home nation
            $title_input['level'] = $this->data['game']['level'];
            $title_info = $this->gamelib->get_title($title_input);
            $new_title = $title_info['title'];
            $better_than = $title_info['better_than'];

            if ($new_title != $this->data['game']['title'] && in_array($this->data['game']['title'], $better_than)) {
                // Promotion!
                $reward = $title_info['reward'];
                
                $data['success'] = 'After faithfully fighting our enemies I here by promote you to ' . $new_title . '! You are getting a reward of ' . $reward . ' doubloons! Keep up the good work!';

                $updates['title'] = $new_title;
                $updates['doubloons']['add'] = true;
                $updates['doubloons']['value'] = $reward;
                $result = $this->Game->update($updates);
                
                $data['changeElements'] = $result['changeElements'];
                
                if ($this->data['user']['sound_effects_play'] == 1) {
                    $data['playSound'] = 'fanfare';
                }
                
                $this->data['json'] = json_encode($data);
                
                $log_input['entry'] = 'is promoted to ' . $new_title . '! A reward of ' . $reward . ' doubloons is given.';
                $log_input['type'] = 'social-status';
                $this->Log->create($log_input);
            } else {
                // Say thank you!
                if ($enemy_victories > 0) {
                    $next_promotion_info = $this->gamelib->get_next_promotion($this->data['game']['level']);
                    $next_promotion = $next_promotion_info - $this->data['game']['level'];

                    $data['info'] = 'Thank you ' . $this->data['game']['title'] . ' ' . ucfirst($this->data['game']['character_name']) . '! We are thankful for your ' . $enemy_victories . ' victories over enemy ships from ' . ucfirst($this->data['game']['enemy']) . '. Sink ' . $next_promotion . ' more, and you will be greatly rewarded!';
                } elseif ($enemy_victories == 0) {
                    $data['info'] = 'It is good to see you as our citizen, but you have not proved your loyalty yet. Please sink some ships from ' . ucfirst($this->data['game']['enemy']) . ' and visit me again.';
                } else {
                    $data['info'] = 'Well, ' . $this->data['game']['title'] . ' ' . ucfirst($this->data['game']['character_name']) . '... It seems to me that you do not want to fight for your nation. You have sunken ' . $enemy_victories . ' ships from ' . ucfirst($this->data['game']['nationality']) . '. and we do not take lightly on this kind of behavior.';
                }
                
                $this->data['json'] = json_encode($data);
            }
        } else {
            // Not the users home nation
            if ($enemy_victories >= floor($town_victories + 10)) {
                // Offer citizenship if the player has won 10 more over the towns enemies than over the town
                $data['info'] = 'It\'s an honor to meet you good sir! As a thank you for the ' . $enemy_victories . ' enemy ships you sunken, I can offer you a citizenzip. Will you accept?';
                $this->data['game']['event_change_citizenship'] = true;
            } elseif ($enemy_victories > $town_victories) {
                // Be nice to the player
                $data['info'] = 'Welcome good sir! We thank you for the ' . $enemy_victories . ' enemy ships you sunken! Please keep up your good work.';
            } elseif ($town_victories == $enemy_victories) {
                // Neutral to the town
                $data['info'] = 'Welcome sir! Help us fight ' . ucfirst($this->data['game']['towns_enemy']) . ' and you will be rewarded!';
            } else {
                // Enemy to the town
                $data['info'] = 'I consider you my enemy! You have sunken ' . $town_victories . ' of our ships! Please go now!';
            }
        }
        
        $this->data['json'] = json_encode($data);
        
        $this->load->view_ajax('cityhall/view_governor', $this->data);
    }

    public function citizenship_accept()
    {
        if ($this->data['game']['place'] !== 'cityhall') {
            return;
        }

        $town_victories = $this->data['game']['victories'][$this->data['game']['nation']];
        $enemy_victories = $this->data['game']['victories'][$this->data['game']['towns_enemy']];
        $title_input['level'] = $enemy_victories - $town_victories;
        $title_info = $this->gamelib->get_title($title_input);
        $new_title = $title_info['title'];

        $data['success'] = 'I am pleased to see you as a citizen! You are now known as a ' . $this->data['game']['nation'] . ' ' . $new_title . '!';
        $data['changeElements']['inventory_title']['text'] = $new_title;
        $data['changeElements']['inventory_nationality']['text'] = $this->data['game']['nation'];
        $data['changeElements']['offer']['remove'] = true;
        
        $updates['title'] = $new_title;
        $updates['nationality'] = $this->data['game']['nation'];
        $result = $this->Game->update($updates);
        
        $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
        
        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'fanfare';
        }
        
        $log_input['entry'] = 'changed citizenship to ' . $this->data['game']['nation'] . ', and were given the title ' . $new_title . '.';
        $log_input['type'] = 'social-status';
        $this->Log->create($log_input);

        echo json_encode($data);
    }

    public function work()
    {
        if ($this->data['game']['place'] !== 'cityhall') {
            return;
        }

        $event = isset($this->data['game']['event']['cityhall_work']) ? $this->data['game']['event']['cityhall_work'] : null;

        if (isset($event['banned']) && $event['banned']) {
            return;
        }

        if (!isset($event['occupation']) ||!isset($event['salary'])) {
            $occupations = array(
                    array('occupation' => 'cleaners', 'salary' => random_int(10, 18)),
                    array('occupation' => 'paramedics', 'salary' => random_int(10, 18)),
                    array('occupation' => 'miners', 'salary' => random_int(15, 25)),
                    array('occupation' => 'postmen', 'salary' => random_int(15, 25)),
                    array('occupation' => 'carpenters', 'salary' => random_int(20, 35)),
                    array('occupation' => 'salesmen', 'salary' => random_int(20, 35)),
                    array('occupation' => 'secretaries', 'salary' => random_int(18, 45)),
                    array('occupation' => 'waiters', 'salary' => random_int(18, 45)),
                    array('occupation' => 'guardians', 'salary' => random_int(40, 50)),
                    array('occupation' => 'bankers', 'salary' => random_int(40, 50))
                );

            $rand_occupation = rand(0, count($occupations) - 1);
            $salary = $occupations[$rand_occupation]['salary'];
            $occupation = $occupations[$rand_occupation]['occupation'];
            $salary = floor(($salary * $this->data['game']['crew_members']) * ($this->data['game']['crew_health_lowest'] / 100));

            $event = array('occupation' => $occupation, 'salary' => $salary);

            $this->data['game']['event']['cityhall_work'] = $event;
            $updates['event']['cityhall_work'] = $event;

            $this->Game->update($updates);
        }

        $this->data['viewdata']['salary'] = $event['salary'];
        $this->data['viewdata']['occupation'] = $event['occupation'];
            
        $this->load->view_ajax('cityhall/view_work', $this->data);
    }

    public function work_accept()
    {
        if ($this->data['game']['place'] !== 'cityhall') {
            return;
        }

        $event = isset($this->data['game']['event']['cityhall_work']) ? $this->data['game']['event']['cityhall_work'] : null;

        if (isset($event['banned']) && $event['banned']) {
            return;
        }
          
        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));

        $updates['event']['cityhall_work']['banned'] = true;
        $this->data['game']['event']['cityhall_work']['banned'] = true;
        $updates['doubloons']['add'] = true;
        $updates['doubloons']['value'] = $event['salary'];
        $updates['week']['add'] = true;
        $updates['week']['value'] = 1;
        $result = $this->Game->update($updates);
            
        $data['changeElements'] = $result['changeElements'];
            
        $data['loadView'] = $this->load->view('cityhall/view_cityhall', $this->data, true);
        $data['pushState'] = base_url('cityhall');

        $updates['all']['mood'] = -1;
        $crew_output = $this->Crew->update($updates);
        if ($crew_output['success'] === true) {
            $data['success'] = 'You and your crew worked for a week as ' . $event['occupation'] . ' and made ' . $event['salary'] . ' dbl!';

            // We have to check the new lowest mood
            $this->data['game']['crew_mood_lowest'] = $crew_output['min_mood'];
                
            $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
                
            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'tired';
            }
                
            $log_input['entry'] = 'and the crew worked for a week as ' . $event['occupation'] . ' and made ' . $event['salary'] . ' dbl.';
            $log_input['type'] = 'labor';
            $this->Log->create($log_input);

            // Update stock worth (week passed)
            $this->load->library('Stockslib');
            $result = $this->stockslib->update_stocks_worth($this->data['game']['stocks']);
            $data['changeElements'] = $result['changeElements'] ? array_merge($data['changeElements'], $result['changeElements']) : $data['changeElements'];

            echo json_encode($data);
        }
    }

    public function prisoners()
    {
        if ($this->data['game']['place'] !== 'cityhall') {
            return;
        }

        if ($this->data['game']['prisoners'] > 0 && $this->data['game']['nation'] == $this->data['game']['nationality']) {
            $reward = floor(rand(300, 1000) * $this->data['game']['prisoners']);
            
            $updates['prisoners'] = 0;
            $updates['doubloons']['add'] = true;
            $updates['doubloons']['value'] = $reward;
            $result = $this->Game->update($updates);
            
            $data['changeElements'] = $result['changeElements'];
            
            $data['success'] = 'You handed in ' . $this->data['game']['prisoners'] . ' prisoners and got a reward of ' . $reward . ' dbl!';

            $data['changeElements']['action_prisoners']['remove'] = true;

            $log_input['entry'] = 'handed in ' . $this->data['game']['prisoners'] . ' prisoners and got a reward of ' . $reward . ' dbl.';
            $log_input['type'] = 'transaction';
            $this->Log->create($log_input);
    
            echo json_encode($data);
        }
    }
}
