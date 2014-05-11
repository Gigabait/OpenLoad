<?php
/***
 * AJAX file. This is where are the AJAX calls goes.
 *
 * Project: OpenLoad
 * Author: Svenskunganka
 * Website: http://svenskunganka.com
 * Contact: http://facepunch.com/member.php?u=445369
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 ***/

// Getting the required libraries and classes.
require '../config/config.inc.php';
require 'db.php';
require '../lib/SourceQuery/SourceQuery.class.php';
require 'openload.class.php';

if(!empty($_POST['args'])) {
	$args = explode("#", $_POST['args']);
	$communityid = $args[0];
	$mapname = $args[1];
	$ip = explode(":", $args[2]);
	$server_ip = $ip[0];
	$server_port = $ip[1];
	$sq = new SourceQuery();
	$sq->Connect($server_ip, $server_port);
	if($db_data && $mysqli) {
		$ol = new OpenLoad($sq, $communityid, $steam_api_key, $mapname, $mysqli, $db_types);
		$ret = $ol->make();
		$mysqli->close();
	}
	else {
		$ol = new OpenLoad($sq, $communityid, $steam_api_key, $mapname);
		$ret = $ol->make();
		$sq->Disconnect();
	}
	$sq->Disconnect();
	$ret['ip'] = $server_ip.':'.$server_port;
	echo json_encode($ret); // Output JSON data.
}
?>