<?php

require_once("autoload.php");





$configs = new stdClass;

$configs->db_type = "mysql";
$configs->db_host = "localhost";
$configs->db_port = 3306;
$configs->db_user = "root";
$configs->db_pass = "alto1234";
$configs->db_name = "mini_sync";
$configs->db_time_zone = "Asia/Jakarta";


$database = new \Sync\PicoDatabase(
	new \Sync\PicoDatabaseServer(
		$configs->db_type,
		$configs->db_host,
		$configs->db_port
	),
	$configs->db_user,
	$configs->db_pass,
	$configs->db_name,
	$configs->db_time_zone
);

$database->connect();

$applicationDir = dirname(dirname(__FILE__));
$baseDir = dirname(dirname(__FILE__));

$fileUpload = new \Sync\FileUpload($applicationDir, $baseDir);