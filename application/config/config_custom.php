<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['site_name']				=	'Lost Seas';
$config['timezone']					=	'Europe/Stockholm';
$config['email']					=	'info@lostseas.com';

$config['google_analytics_id']		=	'X'; // UA-40457155-1

$config['ship_types'] 				= array(
										'brig' => array(
											'load_capacity' => 500,
											'min_crew' => 2,
											'max_crew' => 20,
											'max_cannons' => 10
										),
										'merchantman' => array(
											'load_capacity' => 1000,
											'min_crew' => 1,
											'max_crew' => 10,
											'max_cannons' => 0
										),
										'galleon' => array(
											'load_capacity' => 300,
											'min_crew' => 4,
											'max_crew' => 50,
											'max_cannons' => 25
										),
										'frigate' => array(
											'load_capacity' => 600,
											'min_crew' => 8,
											'max_crew' => 100,
											'max_cannons' => 50
										)
									);
									
$config['towns'] 					= array(
										'ocean' => array(
											'nation' => 'ocean',
											'enemy' => 'none'
										),
										'charles towne' => array(
											'nation' => 'england',
											'enemy' => 'france'
										),
										'belize' => array(
											'nation' => 'england',
											'enemy' => 'france'
										),
										'port royale' => array(
											'nation' => 'england',
											'enemy' => 'france'
										),
										'barbados' => array(
											'nation' => 'england',
											'enemy' => 'france'
										),
										'martinique' => array(
											'nation' => 'france',
											'enemy' => 'england'
										),
										'biloxi' => array(
											'nation' => 'france',
											'enemy' => 'england'
										),
										'tortuga' => array(
											'nation' => 'france',
											'enemy' => 'england'
										),
										'leogane' => array(
											'nation' => 'france',
											'enemy' => 'england'
										),
										'curacao' => array(
											'nation' => 'holland',
											'enemy' => 'spain'
										),
										'st. eustatius' => array(
											'nation' => 'holland',
											'enemy' => 'spain'
										),
										'bonaire' => array(
											'nation' => 'holland',
											'enemy' => 'spain'
										),
										'st. martin' => array(
											'nation' => 'holland',
											'enemy' => 'spain'
										),
										'panama' => array(
											'nation' => 'spain',
											'enemy' => 'holland'
										),
										'san juan' => array(
											'nation' => 'spain',
											'enemy' => 'holland'
										),
										'havana' => array(
											'nation' => 'spain',
											'enemy' => 'holland'
										),
										'villa hermosa' => array(
											'nation' => 'spain',
											'enemy' => 'holland'
										)
									);

$config['prices'] 				= array(
										'food' => array(
											'buy' => 16,
											'sell' => 11
										),
										'water' => array(
											'buy' => 12,
											'sell' => 8
										),
										'porcelain' => array(
											'buy' => 35,
											'sell' => 24
										),
										'spices' => array(
											'buy' => 20,
											'sell' => 14
										),
										'silk' => array(
											'buy' => 45,
											'sell' => 31
										),
										'medicine' => array(
											'buy' => 40,
											'sell' => 28
										),
										'tobacco' => array(
											'buy' => 75,
											'sell' => 52
										),
										'rum' => array(
											'buy' => 150,
											'sell' => 105
										),
										'cannons' => array(
											'buy' => 300,
											'sell' => 210
										),
										'rafts' => array(
											'buy' => 200,
											'sell' => 140
										),
										'tavern_dinners' => array(
											'buy' => 25,
											'sell' => 25
										),
										'tavern_wenches' => array(
											'buy' => 30,
											'sell' => 30
										),
										'tavern_wine' => array(
											'buy' => 50,
											'sell' => 50
										),
										'tavern_rum' => array(
											'buy' => 70,
											'sell' => 70
										),
										'brig' => array(
											'buy' => 1500,
											'sell' => 750
										),
										'merchantman' => array(
											'buy' => 1000,
											'sell' => 500
										),
										'galleon' => array(
											'buy' => 4000,
											'sell' => 2000
										),
										'frigate' => array(
											'buy' => 10000,
											'sell' => 5000
										),
										'ship_repair' => array(
											'buy' => 5,
											'sell' => 5
										)
								  );
