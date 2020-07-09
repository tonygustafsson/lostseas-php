<?php  if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Dark Seas Common Functions
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		Dark Seas Game Library
 * @author		Tony Gustafsson
 * @copyright	Copyright (c) 2010, Tony Gustafsson
 * @license		http://www.tonyg.se/
 * @link		http://www.tonyg.se/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Dark Seas Common Functions Class
 *
 * @package		CodeIgniter
 * @subpackage	Application/Libraries
 * @category	Libraries
 * @author		Tony Gustafsson
 * @link		http://www.tonyg.se/
 */
class GAMELIB
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function get_nations($nation)
    {
        $nations = array(
            'england' => array(
                'nation' => 'england',
                'enemy' => 'france',
                'towns' => array('belize', 'charles towne', 'port royale', 'barbados')
            ),
            'france' => array(
                'nation' => 'france',
                'enemy' => 'england',
                'towns' => array('martinique', 'biloxi', 'tortuga', 'leogane')
            ),
            'holland' => array(
                'nation' => 'holland',
                'enemy' => 'spain',
                'towns' => array('curacao', 'st. eustatius', 'bonaire', 'st. martin')
            ),
            'spain' => array(
                'nation' => 'spain',
                'enemy' => 'holland',
                'towns' => array('panama', 'san juan', 'havana', 'villa hermosa')
            )
        );
        
        if ($nation == 'random') {
            $random_key = array_rand($nations);
            return $nations[$random_key];
        } else {
            return $nations[$nation];
        }
    }

    public function get_title($input)
    {
        if ((isset($input['level']) && $input['level'] <= 9) || (isset($input['title']) && $input['title'] == 'pirate')) {
            $title_info['title'] = 'pirate';
            $title_info['reward'] = 0;
            $title_info['max_ships'] = 3;
            $title_info['better_than'] = array();
        } elseif ((isset($input['level']) && $input['level'] >= 10 && $input['level'] <= 19) || (isset($input['title']) && $input['title'] == 'ensign')) {
            $title_info['title'] = 'ensign';
            $title_info['reward'] = 1000;
            $title_info['max_ships'] = 5;
            $title_info['better_than'] = array('pirate');
        } elseif ((isset($input['level']) && $input['level'] >= 20 && $input['level'] <= 29) || (isset($input['title']) && $input['title'] == 'captain')) {
            $title_info['title'] = 'captain';
            $title_info['reward'] = 2500;
            $title_info['max_ships'] = 6;
            $title_info['better_than'] = array('pirate', 'ensign');
        } elseif ((isset($input['level']) && $input['level'] >= 30 && $input['level'] <= 39) || (isset($input['title']) && $input['title'] == 'major')) {
            $title_info['title'] = 'major';
            $title_info['reward'] = 4000;
            $title_info['max_ships'] = 7;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain');
        } elseif ((isset($input['level']) && $input['level'] >= 40 && $input['level'] <= 49) || (isset($input['title']) && $input['title'] == 'colonel')) {
            $title_info['title'] = 'colonel';
            $title_info['reward'] = 6000;
            $title_info['max_ships'] = 8;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major');
        } elseif ((isset($input['level']) && $input['level'] >= 50 && $input['level'] <= 64) || (isset($input['title']) && $input['title'] == 'admiral')) {
            $title_info['title'] = 'admiral';
            $title_info['reward'] = 8000;
            $title_info['max_ships'] = 10;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major', 'colonel');
        } elseif ((isset($input['level']) && $input['level'] >= 65 && $input['level'] <= 79) || (isset($input['title']) && $input['title'] == 'baron')) {
            $title_info['title'] = 'baron';
            $title_info['reward'] = 10000;
            $title_info['max_ships'] = 11;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major', 'colonel', 'admiral');
        } elseif ((isset($input['level']) && $input['level'] >= 80 && $input['level'] <= 99) || (isset($input['title']) && $input['title'] == 'count')) {
            $title_info['title'] = 'count';
            $title_info['reward'] = 15000;
            $title_info['max_ships'] = 12;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major', 'colonel', 'admiral', 'baron');
        } elseif ((isset($input['level']) && $input['level'] >= 100 && $input['level'] <= 119) || (isset($input['title']) && $input['title'] == 'marquis')) {
            $title_info['title'] = 'marquis';
            $title_info['reward'] = 20000;
            $title_info['max_ships'] = 13;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major', 'colonel', 'admiral', 'baron', 'count');
        } elseif ((isset($input['level']) && $input['level'] >= 120) || (isset($input['title']) && $input['title'] == 'duke')) {
            $title_info['title'] = 'duke';
            $title_info['reward'] = 35000;
            $title_info['max_ships'] = 15;
            $title_info['better_than'] = array('pirate', 'ensign', 'captain', 'major', 'colonel', 'admiral', 'baron', 'count', 'marquis');
        }
        
        return $title_info;
    }
    
    public function ship_spec($manned_cannons, $nation)
    {
        $nations = array('spain', 'france', 'england', 'holland', 'pirate');
        if ($nation != 'ocean') {
            if (rand(0, 1) == 0) {
                $ship['nation'] = $nation;
            } else {
                $ship['nation'] = $nations[array_rand($nations)];
            }
        } else {
            $ship['nation'] = $nations[array_rand($nations)];
        }
        
        $ship_types = array('brig', 'merchantman', 'galleon', 'frigate');
        $ship['type'] = $ship_types[array_rand($ship_types)];
    
        $min_cannons = floor($manned_cannons * 0.8);
        $max_cannons = floor($manned_cannons * 1.1);
        $ship['cannons'] = rand($min_cannons, $max_cannons);
        $ship['cannons'] = ($ship['cannons'] < 1) ? 1 : $ship['cannons'];
        $ship['crew'] = $ship['cannons'] * 2;
        
        return $ship;
    }

    public function get_crew_mood_symbol($crew_mood)
    {
        $data['changeElements']['inventory_crew_mood_aggressive']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_mood_grumpy']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_mood_calm']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_mood_cheerful']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_mood_happy']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_mood_euphoric']['visibility'] = 'none';
      
        if ($crew_mood <= -10) {
            $data['changeElements']['inventory_crew_mood_aggressive']['visibility'] = 'inline-block';
        } elseif ($crew_mood <= 0) {
            $data['changeElements']['inventory_crew_mood_grumpy']['visibility'] = 'inline-block';
        } elseif ($crew_mood <= 5) {
            $data['changeElements']['inventory_crew_mood_calm']['visibility'] = 'inline-block';
        } elseif ($crew_mood <= 10) {
            $data['changeElements']['inventory_crew_mood_cheerful']['visibility'] = 'inline-block';
        } elseif ($crew_mood <= 18) {
            $data['changeElements']['inventory_crew_mood_happy']['visibility'] = 'inline-block';
        } else {
            $data['changeElements']['inventory_crew_mood_euphoric']['visibility'] = 'inline-block';
        }

        return $data['changeElements'];
    }
    
    public function get_crew_friendly_mood($crew_mood)
    {
        switch ($crew_mood) {
            case ($crew_mood <= -10):
                return "aggressive";
            case ($crew_mood > -10 && $crew_mood <= 0):
                return "grumpy";
            case ($crew_mood > 0 && $crew_mood <= 5):
                return "calm";
            case ($crew_mood > 5 && $crew_mood <= 10):
                return "cheerful";
            case ($crew_mood > 10 && $crew_mood <= 18):
                return "happy";
            case ($crew_mood > 18):
                return "euphoric";
            default:
                return "unknown"; //Should never happen...
        }
    }
    
    public function get_crew_health_symbol($crew_health)
    {
        $data['changeElements']['inventory_crew_health_25']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_health_50']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_health_75']['visibility'] = 'none';
        $data['changeElements']['inventory_crew_health_100']['visibility'] = 'none';

        if ($crew_health <= 25) {
            $data['changeElements']['inventory_crew_health_25']['visibility'] = 'block';
        } elseif ($crew_health > 25 && $crew_health <= 50) {
            $data['changeElements']['inventory_crew_health_50']['visibility'] = 'block';
        } elseif ($crew_health > 50 && $crew_health <= 75) {
            $data['changeElements']['inventory_crew_health_75']['visibility'] = 'block';
        } else {
            $data['changeElements']['inventory_crew_health_100']['visibility'] = 'block';
        }
        
        return $data['changeElements'];
    }
    
    public function report_crew_unhappiness($crew)
    {
        $angry_crew = 0;
    
        foreach ($crew as $man) {
            if ($man['mood'] <= -10) {
                $angry_crew++;
            }
        }
        
        return $angry_crew;
    }
    
    public function get_inventory_ship($number_of_ships, $ship_health)
    {
        $data['changeElements']['inventory_ships_health_25']['visibility'] = 'none';
        $data['changeElements']['inventory_ships_health_50']['visibility'] = 'none';
        $data['changeElements']['inventory_ships_health_75']['visibility'] = 'none';
        $data['changeElements']['inventory_ships_health_100']['visibility'] = 'none';

        if ($ship_health <= 25) {
            $data['changeElements']['inventory_ships_health_25']['visibility'] = 'block';
        } elseif ($ship_health > 25 && $ship_health <= 50) {
            $data['changeElements']['inventory_ships_health_50']['visibility'] = 'block';
        } elseif ($ship_health > 50 && $ship_health <= 75) {
            $data['changeElements']['inventory_ships_health_75']['visibility'] = 'block';
        } else {
            $data['changeElements']['inventory_ships_health_100']['visibility'] = 'block';
        }
        
        $data['changeElements']['inventory_ships']['text'] = $number_of_ships;
        $data['changeElements']['inventory_ships_health_link']['title'] = 'You own ' . $number_of_ships . ' ships with the health ' . $ship_health . '%';
        
        return $data['changeElements'];
    }

    public function get_weather()
    {
        $hour = date('H');

        switch ($hour) {
            case "06": return "sunset";
            case "07": return "sunset";
            case "08": return "sunny";
            case "09": return "cloudy";
            case "10": return "rainy";
            case "11": return "cloudy";
            case "12": return "sunny";
            case "13": return "cloudy";
            case "14": return "sunny";
            case "15": return "sunny";
            case "16": return "cloudy";
            case "17": return "sunny";
            case "18": return "rainy";
            case "19": return "sunny";
            case "20": return "sunset";
            case "21": return "sunset";
            case "22": return "sunset";
            case "23": return "night";
            case "00": return "night";
            case "01": return "night";
            case "02": return "night";
            case "03": return "night";
            case "04": return "night";
            case "05": return "night";
        }
    }
    
    public function random_greeting($place, $name, $gender, $age)
    {
        if ($gender == 'M') {
            $title = (($age <= 25 && rand(1, 3) == 1) ? 'Lad' : 'Sir');
        } else {
            $title = (($age <= 25) ? 'Miss' : 'Ma\'am');
        }
    
        if ($place == 'shop') {
            $groceries = array('food', 'water', 'porcelain', 'spices', 'silk', 'tobacco', 'rum');
            $grocery = $groceries[rand(0, count($groceries) - 1)];
        
            $greetings[] = 'Welcome ' . $name . '! What can I do for you?';
            $greetings[] = 'Hello there ' . $name . '! Can I get you anything?';
            $greetings[] = 'Would you be interested in some ' . $grocery . ' today?';
            $greetings[] = 'Welcome ' . $title . '. What can I do for you?';
            $greetings[] = 'Welcome to my simple shop. Is there anything I can get you, ' . $title . '?';
            $greetings[] = 'Any ' . $grocery . ' for you today?';
            $greetings[] = 'I would really recommend the ' . $grocery . ' today, Its incredible!';
            $greetings[] = 'Good day to you ' . $title . '! What can I do for you?';
            $greetings[] = 'Just tell me if there is anything I can do for you, ' . $title . '.';
            $greetings[] = $name . ', your are welcome!';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'tavern') {
            $groceries = array('dinner', 'beer', 'wine');
            $grocery = $groceries[rand(0, count($groceries) - 1)];
        
            $greetings[] = 'Welcome ' . $name . '! What can I do fer ye?';
            $greetings[] = 'Ho there ' . $name . '! Can I get ye anythin\'? A beer maybe?';
            $greetings[] = 'Would ye be interested in some fine ' . $grocery . ' today?';
            $greetings[] = 'Welcome ' . $title . '. What can I do for you?';
            $greetings[] = 'Welcome ter this here tavern. Be there anything I can get ye, ' . $title . '?';
            $greetings[] = 'Any ' . $grocery . ' for ye today?';
            $greetings[] = 'I could really recommend the ' . $grocery . ' today, it\'s incredible!';
            $greetings[] = 'Good day to you ' . $title . '! What can I do for ye?';
            $greetings[] = 'Just tell me if there be anythin\' I can do fer ye, ' . $title . '.';
            $greetings[] = $name . ', ye be welcome!';
            $greetings[] = 'Welcome! Don\'t ye mind the drunks in t\'corner!';
            $greetings[] = 'Heave ahead! Don\'t ye mind the drunks in the corner!';
            $greetings[] = 'Here’s luck and a fair wind to you.';
            $greetings[] = 'Ahoy! How fares your day? I bet all yer travellin\' has made ye thirsty!';
            $greetings[] = 'Speak me yer tidings, ' . $title . '!';
            $greetings[] = 'Ye be welcome to my tavern! What would ye have?';
            $greetings[] = 'Ye come in a fair breeze, ' . $title . '. What can I do fer ye?';
            $greetings[] = 'Arr, me hearty! Ne\'er was there a finer tavern than this here! Be there anything I can get ye?';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'cityhall') {
            $greetings[] = 'You\'re standing in the city hall, and you cannot help but admire the interior...';
            $greetings[] = 'The city hall is open for exploration. A visit to the governor, perhaps?';
            $greetings[] = 'You admire the furniture...';
            $greetings[] = 'I\'m sure the governor would like to speak with you.';
            $greetings[] = 'There is no one here to greet you, but you could try going in to the governor\'s office.';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'bank') {
            $greetings[] = 'Welcome ' . $name . '! What can I do for you today?';
            $greetings[] = 'Hi there ' . $name . '! Is it time to save some money away from the evil pirates?';
            $greetings[] = 'Would you be intrerested in some fine loans today?';
            $greetings[] = 'Welcome ' . $title . '. What can I do for you?';
            $greetings[] = 'Welcome to this modest bank. Is there anything I can get you, ' . $title . '?';
            $greetings[] = 'Any loans for you today?';
            $greetings[] = 'Good day to you ' . $title . '! What can I do for you?';
            $greetings[] = 'Just tell me if there is anything I can do for you, ' . $title . '!';
            $greetings[] = $name . ', your are welcome!';
            $greetings[] = 'You should save your money in your account before you get robbed!';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'shipyard') {
            $groceries = array('brigs', 'merchantmans', 'galleons', 'frigates', 'cannons', 'rafts');
            $grocery = $groceries[rand(0, count($groceries) - 1)];
        
            $greetings[] = 'Welcome ' . $name . '! What can I do for you?';
            $greetings[] = 'Hello there ' . $name . '! Can I get you anything?';
            $greetings[] = 'Would you be interested in some ' . $grocery . ' today?';
            $greetings[] = 'Welcome ' . $title . '. What can I do for you?';
            $greetings[] = 'Welcome to my shipyard. Is there anything I can get you, ' . $title . '?';
            $greetings[] = 'Any ' . $grocery . ' for you today?';
            $greetings[] = 'I could really recommend the ' . $grocery . ', they are incredible!';
            $greetings[] = 'Good day to you ' . $title . '! What can I do for you?';
            $greetings[] = 'Just tell me if there is anything I can do for you, ' . $title . '.';
            $greetings[] = $name . ', your are welcome!';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'market') {
            $greetings[] = 'You are standing in the crowd of people and looking for anything to buy.';
            $greetings[] = 'The crowd is disturbing you a bit, but you\'ll live...';
            $greetings[] = 'You admire the the nice looking lady who sells apples at the corner...';
            $greetings[] = 'Any slaves today maybe?';
            $greetings[] = 'You are strolling around, looking for anything to buy...';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'harbor') {
            $greetings[] = 'You have arrived to the harbor. The weather is good, and you can feel the thirst for adventures!';
            $greetings[] = 'Water under the hull, check. Crew on board, check. What\'s next?';
            $greetings[] = 'You can still see citizens at the town from here.';
            $greetings[] = 'Ah, the open waters...';
            $greetings[] = 'Open water! Is it time to explore the Caribbean sea?';
            $greetings[] = 'The Caribbean Sea is just waiting to be explored!';
            $greetings[] = 'Finally, some adventures!';
            $greetings[] = 'Your crew shouts of happiness...';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'dock') {
            $greetings[] = 'Your standing at the towns docks. You see a lot of ships all around you...';
            $greetings[] = 'You arrive at the tows dock.';
            $greetings[] = 'How about some beers at the tavern?';
            $greetings[] = 'The Caribbean Sea misses you!';
            $greetings[] = 'Let\'s explore this town!';
            $greetings[] = 'You admire the old ships laying around.';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } elseif ($place == 'ocean') {
            $greetings[] = 'The wind is strong!';
            $greetings[] = 'You travel on the Caribbean Sea!';
            $greetings[] = 'Ah, the open waters...';
            $greetings[] = 'Open water! You are exploring the Caribbean sea...';
            $greetings[] = 'The Caribbean Sea is just waiting to be explored!';
            $greetings[] = 'Finally, some adventures!';
            $greetings[] = 'You are still far from land.';
            
            $random_index = rand(0, count($greetings) - 1);
            return $greetings[$random_index];
        } else {
            return false;
        }
    }
    
    public function readable_list($input)
    {
        //Put in an array and get a human readable list with the right commas, spaces and dots.
        $output = '';
        
        for ($x = 0; $x < count($input); $x++) {
            $output .= ($x > 0) ? ' ' : '';
            $output .= $input[$x];
            $output .= ($x == count($input) - 2) ? ' and' : ',';
        }
        
        return substr($output, 0, -1);
    }
    
    public function generate_character()
    {
        $this->CI->load->helper('file');

        $names_character = read_file('assets/lists/names_characters.txt');
        $names_character = explode("\n", $names_character);
        $character_name = $names_character[rand(0, count($names_character) - 1)];
        
        $data['character_name'] = (rand(0, 2) > 0 && strlen($character_name) < 10) ? $character_name . ' ' . $names_character[rand(0, count($names_character))] : $character_name;
        $data['character_age'] = rand(15, 50);
        $data['character_gender'] = (rand(1, 2) == 1) ? 'M' : 'F';
        $data['character_gender_long'] = ($data['character_gender'] == 'M') ? 'male' : 'female';
        
        $avatar_path = APPPATH . '../assets/images/avatars/' . $data['character_gender_long'] . '/avatar_*.png';
        $avatars = glob($avatar_path);
        $random_avatar = rand(1, count($avatars));
        $data['character_avatar'] = $random_avatar;
        $data['character_avatar_path'] = base_url('assets/images/avatars/' . $data['character_gender_long'] . '/avatar_' . $random_avatar . '.png');
        
        return $data;
    }
    
    public function validate_form($input, $rules)
    {
        foreach ($rules as $form_element => $this_rule) {
            $friendly_name = (isset($this_rule['name'])) ? $this_rule['name'] : $form_element;
            if (isset($input[$form_element])) {
                $this_input = $input[$form_element];
            
                foreach ($this_rule as $rule => $limit) {
                    if ($rule == 'min_length' && strlen($this_input) < $limit) {
                        $error[] = '* <em>' . $friendly_name . '</em> must be more than ' . $limit . ' characters!';
                    }
                    
                    if ($rule == 'max_length' && strlen($this_input) > $limit) {
                        $error[] = '* <em>' . $friendly_name . '</em> must be less than ' . $limit . ' characters!';
                    }
                    
                    if ($rule == 'email' && filter_var($this_input, FILTER_VALIDATE_EMAIL) === false) {
                        $error[] = '* <em>' . $friendly_name . '</em> is not a correctly formatted email address.';
                    }
                    
                    if ($rule == 'date' && ! strtotime($this_input)) {
                        $error[] = '* <em>' . $friendly_name . '</em> is not a correctly formatted date.';
                    }
                    
                    if ($rule == 'numeric' && ! is_numeric($this_input)) {
                        $error[] = '* <em>' . $friendly_name . '</em> must be a numeric value.';
                    }
                    
                    if ($rule == 'exact_match') {
                        foreach ($limit as $match) {
                            $matched = false;

                            if ($this_input === $match) {
                                $matched = true;
                                break;
                            }
                        }
                        
                        if (! $matched) {
                            $error[] = '* <em>' . $friendly_name . '</em> did not match.';
                        }
                    }
                    
                    if ($rule == 'in_range') {
                        if (! array_key_exists($this_input, $limit)) {
                            $error[] = '* <em>' . $friendly_name . '</em> is out of range.';
                        }
                    }
                }
            }
        }
        
        if (isset($error)) {
            return implode("<br>", $error);
        } else {
            return false;
        }
    }
}
// END Dark Seas Common class

/* End of file gamelib.php */
/* Location: ./application/libraries/gamelib.php */
