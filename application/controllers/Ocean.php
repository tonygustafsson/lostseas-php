<?php

include('Main.php');

class Ocean extends Main
{
    public function index()
    {
        $this->this_place = 'ocean';
        $accepted_places = array('harbor', 'ocean');
        $data['changeElements'] = array();
        
        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
        $angry_crew = $this->gamelib->report_crew_unhappiness($this->data['crew']);
        $view = ($this->data['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';

        if ($this->input->is_ajax_request()) {
            // Ajax request, make stuff happen
            if (!in_array($this->data['game']['place'], $accepted_places) || isset($this->data['game']['event']['ship_meeting']) || isset($this->data['game']['event']['ship_trade'])) {
                // Do nothing...
            } elseif ($this->data['game']['ships'] < 1) {
                $data['error'] = 'You do not own a ship. This is no time for exploring the ocean. Please paddle to a close town!';
            } elseif ($this->data['game']['crew_members'] < 1) {
                $data['error'] = 'You don\'t have any crew members! This is no time for exploring the ocean. Please sail to a town near by!';
            } elseif ($angry_crew > 0) {
                $data['error'] = $angry_crew . ' of your crew members are angry and do not want to travel any more! You can land your ship at the closest town, give them something to make them less angry, or just discard them.';
            } elseif ($this->data['game']['food'] - $this->data['game']['needed_food'] <= 0) {
                $data['error'] = 'You do not have enough food to keep on traveling. Please go to the closest harbor and stock up some food.';
            } elseif ($this->data['game']['water'] - $this->data['game']['needed_water'] <= 0) {
                $data['error'] = 'You do not have enough water to keep on traveling. Please go to the closest harbor and stock up some water.';
            } else {
                // Everything is OK for traveling to the ocean!
                if (random_int(1, 2) == 1 && !isset($this->data['game']['event']['ship_meeting']) && !isset($this->data['game']['event']['ship_trade']) && $this->data['game']['ships'] > 0) {
                    // Meet a ship!
                    $ship_meeting = $this->gamelib->ship_spec($this->data['game']['manned_cannons'], $this->data['game']['nation']);
                    $ship_meeting['prisoners'] = ($ship_meeting['nation'] == $this->data['game']['enemy'] || $ship_meeting['nation'] == 'pirate') ? floor(rand(0, 2) * rand(0, 1)) : 0;
                    
                    $this->data['game']['event']['ship_meeting'] = $ship_meeting;
                    $updates['event']['ship_meeting'] = $ship_meeting;
                    
                    $data['changeElements']['nav_ocean']['visibility'] = 'none';
                    $data['changeElements']['nav_harbor']['visibility'] = 'none';
                    $data['changeElements']['nav_dock']['visibility'] = 'none';

                    $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = ($ship_meeting['nation'] == 'pirate' || $ship_meeting['nation'] == $this->data['game']['enemy']) ? 'block' : 'none';
                    $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = ($ship_meeting['nation'] == $this->data['game']['nationality']) ? 'block' : 'none';
                    $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = ($ship_meeting['nation'] != 'pirate' && $ship_meeting['nation'] != $this->data['game']['nationality'] && $ship_meeting['nation'] != $this->data['game']['enemy']) ? 'block' : 'none';

                    $data['pushState'] = base_url('ocean/ship_meeting');
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'sailho';
                    }
                } else {
                    $data['changeElements']['nav_ocean']['visibility'] = 'block';
                    $data['changeElements']['nav_harbor']['visibility'] = 'none';
                    $data['changeElements']['nav_dock']['visibility'] = 'none';
                    
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'wind';
                    }
                }

                if ($this->data['game']['place'] != $this->this_place) {
                    //If you are comming from the harbor
                    $updates['event']['cityhall_work'] = null;
                    $updates['event']['tavern_sailors'] = null;
                    $updates['event']['tavern_blackjack'] = null;
                    $updates['event']['market'] = null;

                    $log_input['entry'] = 'leaves the port of ' . ucwords($this->data['game']['town']) . ' to explore the caribbean sea.';
                    $this->Log->create($log_input);
                    
                    $this->data['game']['town'] = $updates['town'] = $this->this_place;
                    $this->data['game']['place'] = $updates['place'] = $this->this_place;
                }

                $updates['food']['sub'] = true;
                $updates['food']['value'] = $this->data['game']['needed_food'];
                $updates['water']['sub'] = true;
                $updates['water']['value'] = $this->data['game']['needed_water'];
                $updates['week']['add'] = true;
                $updates['week']['value'] = 1;
                
                $new_mood = $this->data['game']['crew_lowest_mood'] - 1;
                $updates['all']['mood'] = $new_mood;
                $crew_output = $this->Crew->update($updates);
                
                if ($crew_output['success']) {
                    $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);
                }

                // Update stock worth (week passed)
                $this->load->library('Stockslib');
                $result = $this->stockslib->update_stocks_worth($this->data['game']['stocks']);
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
                
                $result = $this->Game->update($updates);
                $data['changeElements'] = array_merge($data['changeElements'], $result['changeElements']);
            }
        }
        
        $this->data['json'] = json_encode($data);
        
        if (isset($this->data['game']['event']['ship_meeting'])) {
            $view = 'ocean/view_ship_meeting';
        } elseif (isset($this->data['game']['event']['ship_won_results'])) {
            $view = 'ocean/view_ship_won';
        } elseif (isset($this->data['game']['event']['ship_trade'])) {
            $view = 'ocean/view_ship_meeting';
        } else {
            $view = $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
        }

        $this->load->view_ajax($view, $this->data);
    }
    
    public function ship_meeting()
    {
        if (!isset($this->data['game']['event']['ship_meeting'])) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        $this->this_place = 'ocean';
        $accepted_places = array('harbor', 'ocean');
            
        $data['changeElements']['nav_ocean']['visibility'] = 'none';
        $data['changeElements']['nav_harbor']['visibility'] = 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
                    
        $this->data['json'] = json_encode($data);
            
        $this->load->view_ajax('ocean/view_ship_meeting', $this->data);
    }

    public function attack()
    {
        $ship_meeting_event = isset($this->data['game']['event']['ship_meeting']) ? $this->data['game']['event']['ship_meeting'] : null;

        if (!$ship_meeting_event && empty($this->data['game']['flee_fail'])) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['user']['id']));
        
        if ($this->data['game']['manned_cannons'] < 6) {
            $variation = 0.4;
        } elseif ($this->data['game']['manned_cannons'] >= 6 && $this->data['game']['manned_cannons'] < 12) {
            $variation = 0.2;
        } else {
            $variation = 0.1;
        }

        $my_chances = $this->data['game']['manned_cannons'] + rand(0, floor($this->data['game']['manned_cannons'] * $variation));
        $enemy_chances = $ship_meeting_event['cannons'] + rand(0, floor($ship_meeting_event['cannons'] * $variation));
        $my_chances = ($my_chances == $enemy_chances) ? $my_chances + 1 : $my_chances;

        if ($my_chances >= $enemy_chances) {
            // Win the battle!
            $event_msg = 'You win the battle after a violent fight!';

            if (isset($this->data['game']['flee_fail'])) {
                $event_msg = $this->data['game']['flee_fail'] . ' ' . $event_msg;
            }

            $log_msg = ($ship_meeting_event['nation'] == 'pirate') ? 'meets a pirate ship' : 'meets a ship from ' . $ship_meeting_event['nation'];
            $log_msg .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons. The battle is won!';

            // Loot some money
            $looted_money = ($ship_meeting_event['crew'] * rand(10, 100));
                
            $updates['doubloons']['add'] = true;
            $updates['doubloons']['value'] = $looted_money;
                
            $log_msg .= ' ' . $looted_money . ' doubloons is taken.';

            // Give the crew some money too, and increase mood
            $crew_money = floor(($looted_money / 2) / $this->data['game']['crew_members']);
            $crew_updates['all']['doubloons'] = "+" . $crew_money;
            $crew_updates['all']['mood'] = "+2";
            $crew_updates['all']['health'] = rand(-8, -1);

            // Ship health decrease
            $ship_updates['all']['health'] = rand(-8, -1);

            // Put the number of victories one step up
            $victory_nation = ($ship_meeting_event['nation'] == 'pirate') ? 'pirates' : $ship_meeting_event['nation'];
                
            $updates['victories'][$victory_nation] = $this->data['game']['victories'][$victory_nation] + 1;

            // Go through some items to see what we will be able to loot
            $item_list = array('food' => 'cartons', 'water' => 'barrels', 'porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
            $event_items = array();

            foreach ($item_list as $item => $container) {
                if (rand(0, 2) == 0) {
                    $event_items[$item] = $item === 'food' || $item === 'water' ? $ship_meeting_event['crew'] * rand(1, 10) : $ship_meeting_event['crew'] * rand(1, 5);
                } else {
                    $event_items[$item] = 0;
                }
            }

            if ($ship_meeting_event['crew'] < 11) {
                $new_crew = floor($ship_meeting_event['crew'] * (rand(10, 40) / 100));
            } elseif ($ship_meeting_event['crew'] > 11 || $ship_meeting_event['crew'] < 20) {
                $new_crew = floor($ship_meeting_event['crew'] * (rand(3, 10) / 100));
            } else {
                $new_crew = floor($ship_meeting_event['crew'] * (rand(2, 6) / 100));
            }
                
            if ($ship_meeting_event['prisoners'] > 0) {
                $updates['prisoners']['add'] = true;
                $updates['prisoners']['value'] = $ship_meeting_event['prisoners'];
                $log_msg .= ' ' . $ship_meeting_event['prisoners'] . ' men were taken as prisoners.';
            }

            $event = array(
                'items' => $event_items,
                'crew' => $new_crew,
                'doubloons' => $looted_money,
                'prisoners' => $ship_meeting_event['prisoners'],
                'sunken_ships' => 0,
                'crew_deaths' => 0,
                'msg' => $event_msg
            );
                
            $data['changeElements']['nav_ocean']['visibility'] = 'none';
            $data['changeElements']['nav_harbor']['visibility'] = 'none';
            $data['changeElements']['nav_dock']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
        } else {
            // You lose the battle
            $this->data['game']['lost'] = 'You\'ve lost the battle!';
            if (isset($this->data['game']['flee_fail'])) {
                $this->data['game']['lost'] = $this->data['game']['flee_fail'] . ' ' . $this->data['game']['lost'];
            }
                
            $data['changeElements'] = array();

            $log_msg = ($ship_meeting_event['nation'] == 'pirate') ? 'meets a pirate ship' : 'meets a ship from ' . $ship_meeting_event['nation'];
            $log_msg .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons. Unfortunately the battle is lost!';

            //Go through your inventory and take things
            $items = array('food' => 'cartons', 'water' => 'barrels', 'porcelain' => 'cartons', 'spices' => 'cartons', 'silk' => 'cartons', 'medicine' => 'boxes', 'tobacco' => 'cartons', 'rum' => 'barrels');
            
            foreach ($items as $item => $container) {
                if ($this->data['game'][$item] > 0) {
                    $updates[$item]['value'] = ($this->data['game']['ships'] <= 1) ? 0 : $this->data['game'][$item] - floor($this->data['game'][$item] / $this->data['game']['ships']);
                    $this->data['game']['bad'][$item] = 'They took ' . floor($this->data['game'][$item] / $this->data['game']['ships']) . ' ' . $container . ' of ' . $item . ' from you.';
                }
            }

            if ($this->data['game']['doubloons'] > 0) {
                //Take your money if you have any...
                $this->data['game']['bad']['bank'] = 'They took ' . $this->data['game']['doubloons'] . ' doubloons from you.';
                $updates['doubloons']['value'] = 0;
            }

            $sink_ship = ($this->data['game']['ships'] > 1) ? rand(1, 3) : rand(1, 4);
            if ($sink_ship == 1) {
                //Don't sink ship
                $log_msg .= ' The ship is not sunk, but they take all money and loots the goods.';
            } else {
                //Sink ship
                $random_key = array_rand($this->data['ship']);
                $sunken_ship = $this->data['ship'][$random_key];
                    
                $ship_result = $this->Ship->erase(array('id' => $sunken_ship['id']));
                    
                $this->data['game']['ships'] = $ship_result['ships'];
                $data['changeElements'] = array_merge($data['changeElements'], $ship_result['changeElements']);
                    
                $this->data['game']['bad']['coast'] = 'They sink your ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . '.';

                if ($this->data['game']['ships'] > 0) {
                    //You've got more ships so your cool...
                    $log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take all money and loots some of the goods.';
                } else {
                    //No more ships, shit...
                    if ($this->data['game']['rafts'] > 0) {
                        //Phew, you got rafts...
                        $used_rafts = (floor($this->data['game']['crew_members'] / 10) < 1) ? 1 : floor($this->data['game']['crew_members'] / 10);
                        $used_rafts = ($used_rafts > $this->data['game']['rafts']) ? $this->data['game']['rafts'] : $used_rafts;
                        $data['changeElements']['inventory_rafts']['text'] = $this->data['game']['rafts'] - $used_rafts;

                        $rafts_holds = $this->data['game']['rafts'] * 10;
                        $surviving_crew = ($rafts_holds >= $this->data['game']['crew_members']) ? $this->data['game']['crew_members'] : $rafts_holds;
                        $surviving_crew = ($surviving_crew > $this->data['game']['crew_members']) ? $this->data['game']['crew_members'] : $surviving_crew;
                        $killed_crew = $this->data['game']['crew_members'] - $surviving_crew;
                            
                        $updates['rafts']['sub'] = true;
                        $updates['rafts']['value'] = $used_rafts;

                        $crew_input['user_id'] = $this->data['user']['id'];
                        $crew_input['delete_random'] = $killed_crew;
                        $crew_result = $this->Crew->erase($crew_input);
                            
                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                            
                        $manned_cannons = (floor($this->data['game']['crew_members'] / 2) > $this->data['game']['cannons']) ? $this->data['game']['cannons'] : floor($this->data['game']['crew_members'] / 2);
                        $data['changeElements']['inventory_manned_cannons']['text'] = $manned_cannons;
                            
                        $killed_msg = ($killed_crew > 0) ? $killed_crew . ' crew members.' : 'all crew members.';
                        $log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take everything. ' .  $used_rafts . ' rafts are used to save yourself and ' . $killed_msg;
                    } else {
                        //Crap, now you have to swim to land alone
                            
                        //Delete all crew members
                        $crew_input['user_id'] = $this->data['user']['id'];
                        $crew_input['delete_all'] = true;
                        $crew_result = $this->Crew->erase($crew_input);
                            
                        $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
                            
                        $data['changeElements']['inventory_cannons']['text'] = 0;
                        $data['changeElements']['inventory_prisoners']['text'] = 0;
                        $data['changeElements']['inventory_manned_cannons']['text'] = 0;

                        //Get a new town to be stranded at
                        $nation_info = $this->gamelib->get_nations('random');
                        $new_town = $nation_info['towns'][array_rand($nation_info['towns'])];

                        $updates['town'] = $new_town;
                        $updates['place'] = 'dock';
                        $updates['prisoners']['value'] = 0;
                            
                        $this->data['game']['place'] = $updates['place'];

                        $log_msg .= ' They sink the ' . $sunken_ship['type'] . ' ' . $sunken_ship['name'] . ', and they take everything. All your ships are gone, no rafts, and all crew members are dead. This poor ' . $this->data['game']['title'] . ' are washed up at ' . ucfirst($new_town) . ' docks.';
                    }
                }
            }
                
            //Give crew less health and decrease mood
            $crew_updates['all']['health'] = rand(-20, -1);
            $crew_updates['all']['mood'] = -1;
                
            //Ship health decrease
            $ship_updates['all']['health'] = rand(-20, -1);
                
            $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
            $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
            $data['changeElements']['nav_dock']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
                
            $data['pushState'] = base_url($this->data['game']['place']);
        }
            
        // Below is happening either you win or lose
        $data['triggerJsEvents'][] = 'ocean-battle-over';
            
        // Ship health decrease
        $ship_output = $this->Ship->update($ship_updates);

        if (isset($event)) {
            $event['sunken_ships'] = $ship_output['ship_destroyed_count'];
        }

        if ($ship_output['ship_destroyed_count'] > 0) {
            $log_msg .= ' ' . $ship_output['ship_destroyed_count'] . ' ships crashed because of ship damages!';
            $this->data['game']['bad']['coast'] = $ship_output['ship_destroyed_count'] . ' of your ships crashed because of ship damages!';
        }
            
        $data['changeElements'] = array_merge($data['changeElements'], $ship_output['changeElements']);

        //Give crew less health and decrease mood
        $crew_output = $this->Crew->update($crew_updates);
        $this->data['game']['crew_members'] = $crew_output['num_crew'];
            
        if (isset($event)) {
            $event['crew_deaths'] = $crew_output['death_count'];
        }

        if ($crew_output['death_count'] > 0) {
            $this->data['game']['bad']['tavern_sailor'] = $crew_output['death_count'] . ' of your crew members died in battle.';
            $log_msg .= ' However, ' . $crew_output['death_count'] . ' of crew members died in battle.';
        }
            
        $data['changeElements'] = array_merge($data['changeElements'], $crew_output['changeElements']);

        if ($this->data['user']['sound_effects_play'] == 1) {
            $data['playSound'] = 'cannons';
        }
            
        $this->data['game']['crew_members'] = $crew_output['num_crew'];
        $this->data['game']['crew_health_lowest'] = $crew_output['min_health'];
        $this->data['game']['crew_lowest_mood'] = $crew_output['min_mood'];

        $this->data['game']['event']['ship_meeting'] = null;
        $updates['event']['ship_meeting'] = null;

        $this->data['game']['event']['ship_won_results'] = isset($event) ? $event : null;
        $updates['event']['ship_won_results'] = isset($event) ? $event : null;

        $game_result = $this->Game->update($updates);
        $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
    
        $controller = $this->event_method($this->data['game']);
        if ($controller) {
            $data['pushState'] = base_url($controller);
        }
                    
        $this->data['json'] = json_encode($data);

        $log_input['entry'] = $log_msg;
        $this->Log->create($log_input);
          
        if (isset($this->data['game']['event']['ship_meeting'])) {
            $view = 'ocean/view_ship_meeting';
        } elseif (isset($this->data['game']['event']['ship_trade'])) {
            $view = 'ocean/view_ocean_trade';
        } elseif (isset($this->data['game']['event']['ship_won_results'])) {
            $view = 'ocean/view_ship_won';
        } else {
            $view = 'ocean/view_ocean';
        }
            
        $this->load->view_ajax($view, $this->data);
    }
    
    public function ship_won()
    {
        if (isset($this->data['game']['event']['ship_won_results'])) {
            $this->load->view_ajax('ocean/view_ship_won', $this->data);
        } else {
            redirect(base_url($this->data['game']['place']));
        }
    }

    public function ship_won_transfer()
    {
        $event = isset($this->data['game']['event']['ship_won_results']) ? $this->data['game']['event']['ship_won_results'] : null;

        if (!isset($event)) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        $data['changeElements'] = array();
        $data['success'] = '';
        $log_input['entry'] = '';
        $total_load = $this->data['game']['load_current'];
        $updates = array();
        $items = array('food' => 16, 'water' => 12, 'porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);

        foreach ($items as $item => $cost) {
            $new_quantity = $this->input->post($item . '_new_quantity');
            $max_quantity = $this->data['game'][$item] + $event['items'][$item];
            $current_quantity = $this->data['game'][$item];

            if ($new_quantity > $current_quantity && $new_quantity <= $max_quantity) {
                //The item is not the same as in $game, and prevent cheating
                $updates[$item]['value'] = $new_quantity;
                $data['changeElements']['inventory_' . $item]['text'] = $new_quantity;
                $item_msg[] = 'looted ' . ($new_quantity - $current_quantity) . ' cartons of ' . $item;
                $total_load += ($new_quantity - $current_quantity);
            }
        }
            
        $new_crew = $this->input->post('crew_new_quantity') - $this->data['game']['crew_members'];

        if ($total_load > $this->data['game']['load_max']) {
            $data['error'] = 'Your ships cannot load that much!';
            $view = 'ocean/view_ship_won';
        } elseif ($new_crew > 0 && ($this->data['game']['crew_members'] + $new_crew > $this->data['game']['max_crew'])) {
            $data['error'] = 'Your ships cannot hold more than ' . $this->data['game']['max_crew'] . ' crew members';
            $view = 'ocean/view_ship_won';
        } elseif (count($updates) < 1 && $new_crew < 1) {
            $data['info'] = 'You decided not to loot anything.';
                
            $this->data['game']['event']['ship_won_results'] = null;
            $updates['event']['ship_won_results'] = null;
            $this->Game->update($updates);
                
            $view = 'ocean/view_ocean';
        } else {
            if (isset($item_msg)) {
                $item_msg = $this->gamelib->readable_list($item_msg);
                $data['success'] .= 'You ' . $item_msg . '.';
                $log_input['entry'] .= $item_msg;
            }
            
            $this->data['game']['load_current'] = $total_load;

            if ($new_crew > 0) {
                $data['success'] .= ' ' . $new_crew . ' sailors were taken in as crew members.';
                $log_input['entry'] .= ' ' . $new_crew . ' sailors were taken in as crew members.';
                    
                $crew_input['user_id'] = $this->data['user']['id'];
                $crew_input['number_of_men'] = $new_crew;
                $crew_input['week'] = $this->data['game']['week'];
                $crew_input['nationality'] = 'random';
                $crew_input['health'] = rand(50, 100);
                $crew_result = $this->Crew->create($crew_input);
                    
                $data['changeElements'] = array_merge($data['changeElements'], $crew_result['changeElements']);
            }
                
            $this->data['game']['event']['ship_won_results'] = null;
            $updates['event']['ship_won_results'] = null;

            $game_result = $this->Game->update($updates);
            $data['changeElements'] = array_merge($data['changeElements'], $game_result['changeElements']);
                
            if ($this->data['user']['sound_effects_play'] == 1) {
                $data['playSound'] = 'cheering';
            }

            if (! empty($data['success'])) {
                $this->Log->create($log_input);
            }
                
            $view = $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
        }
            
        $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
        $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
            
        $data['loadView'] = $this->load->view($view, $this->data, true);
        $data['pushState'] = base_url($this->data['game']['place']);
        $data['triggerJsEvents'][] = 'ocean-battle-transfer-done';

        echo json_encode($data);
    }

    public function ship_won_cancel()
    {
        $event = isset($this->data['game']['event']['ship_won_results']) ? $this->data['game']['event']['ship_won_results'] : null;

        if (!isset($event)) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        $this->data['game']['event']['ship_won_results'] = null;
        $updates['event']['ship_won_results'] = null;

        $this->data['game']['event']['ship_meeting'] = null;
        $updates['event']['ship_meeting'] = null;

        $result = $this->Game->update($updates);
            
        $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
        $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
            
        $data['info'] = 'You decided not to loot anything.';
            
        $data['pushState'] = base_url($this->data['game']['place']);
            
        $this->data['json'] = json_encode($data);
            
        $view = $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
        $this->load->view_ajax($view, $this->data);
    }

    public function ignore()
    {
        $ship_meeting_event = isset($this->data['game']['event']['ship_meeting']) ? $this->data['game']['event']['ship_meeting'] : null;

        if (!$ship_meeting_event) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        $this->data['game']['event']['ship_meeting'] = null;
        $updates['event']['ship_meeting'] = null;

        $result = $this->Game->update($updates);

        $data['info'] = ($ship_meeting_event['nation'] == 'pirate') ? 'You ignored a pirate ship' : 'You ignored a ship from ' . ucfirst($ship_meeting_event['nation']);
        $data['info'] .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons.';
            
        $log_input['entry'] = ($ship_meeting_event['nation'] == 'pirate') ? 'ignored a pirate ship' : 'ignored a ship from ' . ucfirst($ship_meeting_event['nation']);
        $log_input['entry'] .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons.';
        $this->Log->create($log_input);
            
        $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
        $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

        $data['pushState'] = base_url($this->data['game']['place']);
            
        $this->data['json'] = json_encode($data);

        $view = ($this->data['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
        $this->load->view_ajax($view, $this->data);
    }

    public function flee()
    {
        $ship_meeting_event = isset($this->data['game']['event']['ship_meeting']) ? $this->data['game']['event']['ship_meeting'] : null;

        if (!$ship_meeting_event) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        if (rand(1, 4) == 1) {
            $this->data['game']['flee_fail'] = 'You tried to flee from a ' . $ship_meeting_event['type'] . ' from ' . $ship_meeting_event['nation'] . ' with ' . $ship_meeting_event['crew']  . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons, but did not succeed.';
            $this->attack($this->data);
            return;
        }
        
        $this->data['game']['event']['ship_meeting'] = null;
        $updates['event']['ship_meeting'] = null;

        $result = $this->Game->update($updates);

        $data['info'] = ($ship_meeting_event['nation'] === 'pirate') ? 'You fled from a pirate ship' : 'You fled from a ship from ' . $ship_meeting_event['nation'];
        $data['info'] .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons.';
                
        $log_input['entry'] = ($ship_meeting_event['nation'] === 'pirate') ? 'fled from a pirate ship' : 'fled from a ship from ' . $ship_meeting_event['nation'];
        $log_input['entry'] .= ' with ' . $ship_meeting_event['crew'] . ' crew members and ' . $ship_meeting_event['cannons'] . ' cannons.';
        $this->Log->create($log_input);

        $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
        $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

        $data['pushState'] = base_url($this->data['game']['place']);

        $this->data['json'] = json_encode($data);
                
        $view = (isset($this->data['game']['event']['ship_trade'])) ? 'ocean/view_ship_meeting' : $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
        $this->load->view_ajax($view, $this->data);
    }

    public function trade()
    {
        $ship_meeting_event = isset($this->data['game']['event']['ship_meeting']) ? $this->data['game']['event']['ship_meeting'] : null;

        if (!$ship_meeting_event) {
            redirect(base_url($this->data['game']['place']));
            return;
        }

        if ($ship_meeting_event['nation'] !== $this->data['game']['nationality']) {
            return;
        }

        $trade_worth = 0;
        $barter_goods = array('porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);

        foreach ($barter_goods as $item => $worth) {
            if ($this->data['game'][$item] > 0) {
                $trade_worth += $this->data['game'][$item] * $worth;
            }
        }

        if ($trade_worth > 0) {
            $event = array('worth' => $trade_worth);
            $this->data['game']['event']['ship_trade'] = $event;
            $updates['event']['ship_trade'] = $event;
                    
            $data['changeElements']['nav_ocean']['visibility'] = 'none';
            $data['changeElements']['nav_harbor']['visibility'] = 'none';
            $data['changeElements']['nav_dock']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
        } else {
            $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
            $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
            $data['changeElements']['nav_dock']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';

            $view = ($this->data['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
            $data['loadView'] = $this->load->view($view, $this->data, true);
            $data['pushState'] = base_url($this->data['game']['place']);
                    
            $this->data['game']['event']['ship_meeting'] = null;
            $updates['event']['ship_meeting'] = null;

            $data['info'] = 'It was nice speakin\' to you, ' . $this->data['game']['character_name'] . ', but you don\'t have anything I could use...';
        }
                
        $result = $this->Game->update($updates);
                
        $this->data['json'] = json_encode($data);

        $this->load->view_ajax('ocean/view_ocean_trade', $this->data);
    }

    public function trade_transfer()
    {
        $event = isset($this->data['game']['event']['ship_trade']) ? $this->data['game']['event']['ship_trade'] : null;

        if (!$event) {
            redirect(base_url($this->data['game']['place']));
        }

        $items = array('food' => 16, 'water' => 12);
        $trade_worth = $event['worth'];
        $total_cost = 0;
        $total_load = $this->data['game']['load_current'];
        $msg_get_list = array();
        $msg_away_list = array();

        foreach ($items as $item => $cost) {
            $new_quantity = $_POST[$item . '_new_quantity'];
            $current_quantity = $this->data['game'][$item];

            if ($new_quantity > $current_quantity) {
                $total_cost += floor($new_quantity - $current_quantity) * $cost;
                $updates[$item]['value'] = $new_quantity;
                $msg_get_list[] = floor($new_quantity - $current_quantity) . ' cartons of ' . $item;
                $total_load += $new_quantity - $current_quantity;
            }
        }

        if (($trade_worth - floor($total_cost)) < 0) {
            $data['error'] = 'You don\'t have that much barter goods to trade with!';
            echo json_encode($data);
        } elseif (($this->data['game']['load_max'] - $total_load) < 0) {
            $data['error'] = 'Your ships cannot load that much!';
            echo json_encode($data);
        } else {
            $this->data['game']['load_current'] = $total_load;
            $this->data['game']['event']['ship_trade'] = null;
            $updates['event']['ship_trade'] = null;

            $this->data['game']['event']['ship_meeting'] = null;
            $updates['event']['ship_meeting'] = null;

            $barter_goods = array('porcelain' => 35, 'spices' => 20, 'silk' => 45, 'medicine' => 40, 'tobacco' => 75, 'rum' => 150);
            
            foreach ($barter_goods as $item => $cost) {
                if ($total_cost > 0) {
                    $item_trade_away = ($this->data['game'][$item] * $cost < $total_cost) ? $this->data['game'][$item] : ceil($total_cost / $cost);

                    if ($item_trade_away > 0) {
                        $this->data['game'][$item] -= $item_trade_away;
                        $updates[$item] = $this->data['game'][$item];
                        $msg_away_list[] = $item_trade_away . ' cartons of ' . $item;
                        $total_cost -= $item_trade_away * $cost;
                    }
                        
                    if ($this->data['user']['sound_effects_play'] == 1) {
                        $data['playSound'] = 'coins';
                    }
                }
            }

            if (count($msg_away_list) > 0 && count($msg_get_list) > 0) {
                $msg_away = $this->gamelib->readable_list($msg_away_list);
                $msg_get = $this->gamelib->readable_list($msg_get_list);
                $data['success'] = 'You traded away ' . $msg_away . ' for ' . $msg_get . '.';
                    
                $log_input['entry'] = 'traded away ' . $msg_away . ' for ' . $msg_get . ' with an allied ship.';
                $this->Log->create($log_input);
            } else {
                $data['info'] = 'You decided not to trade anything.';
            }

            $result = $this->Game->update($updates);
            $data['changeElements'] = $result['changeElements'];
                
            $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
            $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
            $data['changeElements']['nav_dock']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
            $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
            $data['triggerJsEvents'][] = 'ocean-trade-done';

            $view = ($this->data['game']['place'] == 'ocean') ? 'ocean/view_ocean' : 'harbor/view_harbor';
            $data['loadView'] = $this->load->view($view, $this->data, true);
            $data['pushState'] = base_url($this->data['game']['place']);

            echo json_encode($data);
        }
    }

    public function trade_cancel()
    {
        $event = isset($this->data['game']['event']['ship_trade']) ? $this->data['game']['event']['ship_trade'] : null;

        if (!$event) {
            redirect(base_url($this->data['game']['place']));
        }

        $this->data['game']['event']['ship_trade'] = null;
        $updates['event']['ship_trade'] = null;

        $this->data['game']['event']['ship_meeting'] = null;
        $updates['event']['ship_meeting'] = null;

        $result = $this->Game->update($updates);
            
        $data['info'] = 'You canceled the trading, said good buy to your allies.';
            
        $data['changeElements']['nav_ocean']['visibility'] = ($this->data['game']['place'] == 'ocean') ? 'block' : 'none';
        $data['changeElements']['nav_harbor']['visibility'] = ($this->data['game']['place'] == 'harbor') ? 'block' : 'none';
        $data['changeElements']['nav_dock']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_unfriendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_friendly']['visibility'] = 'none';
        $data['changeElements']['nav_ship_meeting_neutral']['visibility'] = 'none';
            
        $this->data['json'] = json_encode($data);

        $view = $this->data['game']['place'] . '/view_' . $this->data['game']['place'];
        $this->load->view_ajax($view, $this->data);
    }
}
