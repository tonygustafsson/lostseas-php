<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = true;

$db['default']['hostname'] = "lostseas-177202.mysql.binero.se";
$db['default']['database'] = "177202-lostseas";
$db['default']['username'] = "177202_qn90643";
$db['default']['password'] = "0HoyPirateDataBase!";

$db['default']['dbdriver'] = "mysqli";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = true;
$db['default']['db_debug'] = true;
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = true;
$db['default']['stricton'] = false;

// My own database variables
$db['default']['user_table'] 		= "ls_user";
$db['default']['game_table'] 		= "ls_game";
$db['default']['ship_table']		= "ls_ship";
$db['default']['crew_table'] 		= "ls_crew";
$db['default']['log_table'] 		= "ls_log";
$db['default']['history_table'] 	= "ls_history";

/* End of file database.php */
/* Location: ./application/config/database.php */
