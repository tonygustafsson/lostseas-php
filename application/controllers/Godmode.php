<?php

include('Main.php');

class Godmode extends Main
{
    public function __construct()
    {
        parent::__construct();
    
        if ($this->data['user']['admin'] < 1) {
            //Don't let unautherized users access this feature
            exit;
        }
    }

    public function index()
    {
        $this->data['players'] = $this->User->get_players();
        $this->data['player'] = ($this->uri->segment(3) != $this->data['user']['id']) ? $this->get_user_data($this->uri->segment(3)) : $this->data;

        $this->load->view_ajax('godmode/view_godmode_game', $this->data);
    }
    
    public function game_update()
    {
        $change_msg = '';
        $this->data['player'] = ($this->input->post('user_id') !== $this->data['user']['id']) ? $this->get_user_data($this->input->post('user_id')) : $this->data;
    
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $val) {
                if ($this->data['player']['game'][$key] !== $val) {
                    $change_msg .= 'You have changed ' . $key . ' to \'' . $val . '\'. ';
                    $updates[$key] = $val;
                }
            }
        }
        
        if (isset($updates)) {
            $updates['user_id'] = $this->input->post('user_id');
            $game_result = $this->Game->update($updates);
            
            if (! isset($game_result['error'])) {
                $data['success'] = 'Success. ' . $change_msg;
                
                if ($this->data['user']['id'] === $this->data['player']['user']['id']) {
                    //Only update inventory if it's your own user
                    $data['changeElements'] = $game_result['changeElements'];
                }
            } else {
                $data['error'] = 'Error: ' . $game_result['error'];
            }
        } else {
            $data['info'] = 'No changes made...';
        }
        
        echo json_encode($data);
    }

    public function reset_event()
    {
        $item = $this->uri->segment(3);
        $user_id = $this->uri->segment(4);

        $this->data['player'] = ($user_id !== $this->data['user']['id']) ? $this->get_user_data($user_id) : $this->data;

        if (!$this->data['player']) {
            return;
        }

        $valid_items = array('tavern_blackjack', 'tavern_sailors', 'market_goods', 'market_slaves', 'cityhall_work');

        if (in_array($item, $valid_items)) {
            $this->data['player']['game']['event'][$item] = null;
            $db_updates['event'][$item] = null;
            $data['success'] = 'Resetted Black jack event.';
        }

        if (isset($db_updates)) {
            $this->Game->update($db_updates);
        } else {
            $data['info'] = 'No changes made.';
        }

        $data['event'] = 'updated-dom';
        $data['loadView'] = $this->load->view('godmode/view_godmode_game', $this->data, true);

        echo json_encode($data);
    }
    
    public function user()
    {
        $this->data['players'] = $this->User->get_players();
        $this->data['player'] = ($this->uri->segment(3) != $this->data['user']['id']) ? $this->get_user_data($this->uri->segment(3)) : $this->data;

        $this->load->view_ajax('godmode/view_godmode_user', $this->data);
    }
    
    public function user_update()
    {
        $change_msg = '';
        $this->data['player'] = ($this->input->post('id') !== $this->data['user']['id']) ? $this->get_user_data($this->input->post('id')) : $this->data;
    
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $val) {
                if ($this->data['player']['user'][$key] !== $val) {
                    $change_msg .= 'You have changed ' . $key . ' to \'' . $val . '\'. ';
                    unset($user_updates);
                    $user_updates[$key] = $val;
                    $this->User->update('id', $this->data['player']['user']['id'], $user_updates);
                }
            }
        }
        
        if (strlen($change_msg) > 0) {
            $data['success'] = 'Success. ' . $change_msg;
        } else {
            $data['info'] = 'No changes made...';
        }
        
        echo json_encode($data);
    }
    
    public function ship()
    {
        $this->data['players'] = $this->User->get_players();
        $this->data['player'] = ($this->uri->segment(3) != $this->data['user']['id']) ? $this->get_user_data($this->uri->segment(3)) : $this->data;
    
        $this->data['player_ships'] = $this->Ship->get($this->data['player']['user']['id']);
    
        $this->load->view_ajax('godmode/view_godmode_ship', $this->data);
    }
    
    public function ship_create()
    {
        $input['user_id'] = $this->uri->segment(3);
        $ship_output = $this->Ship->create($input);
    
        if ($ship_output['success'] === true) {
            $data['success'] = 'Created a new ship!';
        
            if ($this->data['user']['id'] === $input['user_id']) {
                //Update inventory if it's your own user
                $data['changeElements'] = $ship_output['changeElements'];
            }
        
            $table_row = '	<tr id="' . $ship_output['created_ship']['id'] . '_row">
								<td>
									<a class="ajaxJSON" href="' . base_url('godmode/ship_delete/' . $ship_output['created_ship']['id']) . '" title="Delete ship"><svg width="16" height="16" alt="Change all"><use xlink:href="#broom"></use></svg></a>
									<input type="text" id="' . $ship_output['created_ship']['id'] . '_name" name="' . $ship_output['created_ship']['id'] . '_name" value="' . $ship_output['created_ship']['name'] . '">
								</td>
								<td><input type="text" id="' . $ship_output['created_ship']['id'] . '_type" name="' . $ship_output['created_ship']['id'] . '_type" value="' . $ship_output['created_ship']['type'] . '"></td>
								<td><input type="number" id="' . $ship_output['created_ship']['id'] . '_age" name="' . $ship_output['created_ship']['id'] . '_age" value="' . $ship_output['created_ship']['age'] . '"></td>
								<td><input type="number" id="' . $ship_output['created_ship']['id'] . '_health" name="' . $ship_output['created_ship']['id'] . '_health" value="' . $ship_output['created_ship']['health'] . '"></td>
							</tr>
						';
                        
            $data['changeElements']['ship_table']['append'] = $table_row;
        } else {
            $data['error'] = 'Something went wrong. No ship created...';
        }
        
        echo json_encode($data);
    }
    
    public function ship_update()
    {
        if ($this->input->post()) {
            $this->data['player'] = ($this->input->post('user_id') !== $this->data['user']['id']) ? $this->get_user_data($this->input->post('user_id')) : $this->data;
        
            foreach ($this->input->post() as $key => $val) {
                if ($key != "user_id") {
                    $key = explode("_", $key);
                    $ship_id = $key[0];
                    $ship_name = $this->data['player']['ship'][$ship_id]['name'];
                    $ship_key = $key[1];
                    $key = implode("_", $key);
                    
                    //Remove convert + and - to right numbers before sending it back to view
                    if (substr($val, 0, 1) == "+") {
                        $returnVal = $this->data['player']['ship'][$ship_id][$ship_key] + substr($val, 1);
                    } elseif (substr($val, 0, 1) == "-") {
                        $returnVal = $this->data['player']['ship'][$ship_id][$ship_key] - substr($val, 1);
                    } else {
                        $returnVal = $val;
                    }
                    
                    if ($this->data['player']['ship'][$ship_id][$ship_key] !== $val) {
                        $updates[$ship_id][$ship_key] = $val;
                    }
                }
            }
        }
        
        if (isset($updates)) {
            $updates['player'] = $this->data['player'];
            $update_result = $this->Ship->update($updates);
            
            if ($update_result['success']) {
                if ($this->data['user']['id'] === $this->data['player']['user']['id']) {
                    //Update inventory if it's your own user
                    $data['changeElements'] = $update_result['changeElements'];
                }

                $data['success'] = 'Success! Changed ' . $update_result['affected_ships'] . ' ships.';
                
                if ($update_result['ship_destroyed_count'] > 0) {
                    $data['success'] .= ' Unfortunately ' . $update_result['ship_destroyed_count'] . ' of your ships were destroyed.';
                    
                    foreach ($update_result['ship_destroyed'] as $affected_ship) {
                        $data['changeElements'][$affected_ship['id'] . '_row']['remove'] = true;
                    }
                }
            } else {
                $data['error'] = 'Something went wrong...';
            }
        } else {
            $data['info'] = 'No changes made...';
        }
        
        echo json_encode($data);
    }
    
    public function ship_delete()
    {
        $input['id'] = $this->uri->segment(3);
        $ship_output = $this->Ship->erase($input);
        
        if ($ship_output['action'] == 'single') {
            $data['success'] = 'Deleted ship with ID ' . $ship_output['id'] . '!';
            
            if (isset($this->data['ship'][$input['id']])) {
                //Update inventory if it's your own ship
                $data['changeElements'] = $ship_output['changeElements'];
            }
            
            $data['changeElements'][$input['id'] . '_row']['remove'] = true;
        } else {
            $data['error'] = 'Something went wrong. No ships were deleted...';
        }
        
        echo json_encode($data);
    }
    
    public function crew()
    {
        $this->data['players'] = $this->User->get_players();
        $this->data['player'] = ($this->uri->segment(3) != $this->data['user']['id']) ? $this->get_user_data($this->uri->segment(3)) : $this->data;
    
        $this->data['crew'] = $this->Crew->get(array('user_id' => $this->data['player']['user']['id']));
        $this->load->view_ajax('godmode/view_godmode_crew', $this->data);
    }

    public function design()
    {
        $this->load->view_ajax('godmode/view_godmode_design', $this->data);
    }
    
    public function crew_create()
    {
        $input['user_id'] = $this->uri->segment(3);
        $crew_output = $this->Crew->create($input);
    
        if ($crew_output['created_crew_count'] > 0) {
            $data['success'] = 'Created ' . $crew_output['created_crew_count'] . ' new crew member!';
            
            foreach ($crew_output['created_crew'] as $crew_member) {
                $table_row = '	<tr id="' . $crew_member['id'] . '_row">
									<td>
										<a class="ajaxJSON" href="' . base_url('godmode/crew_delete/' . $crew_member['id']) . '" title="Delete crew member"><svg width="16" height="16" alt="Change all"><use xlink:href="#broom"></use></svg></a>
										<input type="text" id="' . $crew_member['id'] . '_name" name="' . $crew_member['id'] . '_name" value="' . $crew_member['name'] . '">
									</td>
									<td><input type="number" id="' . $crew_member['id'] . '_mood" name="' . $crew_member['id'] . '_mood" value="' . $crew_member['mood'] . '"></td>
									<td><input type="number" id="' . $crew_member['id'] . '_health" name="' . $crew_member['id'] . '_health" value="' . $crew_member['health'] . '"></td>
									<td><input type="number" id="' . $crew_member['id'] . '_doubloons" name="' . $crew_member['id'] . '_doubloons" value="' . $crew_member['doubloons'] . '"></td>
								</tr>
							';
                            
                $data['changeElements'] = $crew_output['changeElements'];
                $data['changeElements']['crew_table']['append'] = $table_row;
            }
        } else {
            $data['error'] = 'Something went wrong. No crew members created...';
        }
        
        echo json_encode($data);
    }
    
    public function crew_update()
    {
        $this->data['player'] = ($this->input->post('user_id') !== $this->data['user']['id']) ? $this->get_user_data($this->input->post('user_id')) : $this->data;
        $this->data['player']['crew'] = $this->Crew->get(array('user_id' => $this->input->post('user_id')));

        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $val) {
                if ($key != 'user_id') {
                    $key = explode("_", $key);
                    $crew_id = $key[0];
                    $crew_name = $this->data['player']['crew'][$crew_id]['name'];
                    $crew_key = $key[1];
                    $key = implode("_", $key);
                    
                    //Remove convert + and - to right numbers before sending it back to view
                    if (substr($val, 0, 1) == "+") {
                        $returnVal = $this->data['player']['crew'][$crew_id][$crew_key] + substr($val, 1);
                    } elseif (substr($val, 0, 1) == "-") {
                        $returnVal = $this->data['player']['crew'][$crew_id][$crew_key] - substr($val, 1);
                    } else {
                        $returnVal = $val;
                    }
                    
                    if ($this->data['player']['crew'][$crew_id][$crew_key] !== $val) {
                        $updates[$crew_id][$crew_key] = $val;
                    }
                }
            }
        }
        
        if (isset($updates)) {
            $updates['player'] = $this->data['player'];
            $update_result = $this->Crew->update($updates);

            if ($update_result['success']) {
                if ($this->data['user']['id'] === $this->data['player']['user']['id']) {
                    //Only update the inventory if it's your own user
                    $data['changeElements'] = $update_result['changeElements'];
                }

                $data['success'] = 'Success! Changed ' . $update_result['affected_crew_members'] . ' crew members.';
                
                if ($update_result['death_count'] > 0) {
                    $data['success'] .= ' Unfortunately ' . $update_result['death_count'] . ' of your crew died.';
                    
                    foreach ($update_result['crew_died'] as $affected_crew) {
                        $data['changeElements'][$affected_crew['id'] . '_row']['remove'] = true;
                    }
                }
            } else {
                $data['error'] = 'Something went wrong...';
            }
        } else {
            $data['info'] = 'No changes made...';
        }
        
        echo json_encode($data);
    }
    
    public function crew_delete()
    {
        $input['id'] = $this->uri->segment(3);
        $crew_output = $this->Crew->erase($input);
        
        if ($crew_output['action'] == 'single') {
            $data['success'] = 'Deleted crew member with ID ' . $crew_output['id'] . '!';
            $data['changeElements'] = $crew_output['changeElements'];
            $data['changeElements'][$input['id'] . '_row']['remove'] = true;
        } else {
            $data['error'] = 'Something went wrong. No crew members were deleted...';
        }
        
        echo json_encode($data);
    }

    public function erase_temp_users()
    {
        $erased_users = $this->User->erase_temp_users();
        
        $data['success'] = 'Deleted ' . $erased_users . ' users.';
        echo json_encode($data);
    }
}
