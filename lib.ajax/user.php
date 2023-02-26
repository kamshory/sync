<?php

require_once(dirname(dirname(__FILE__)) . "/lib.inc/functions.php");

$rec = new \Sync\SyncUser($database);
header("Content-type: application/json");
$page = isset($_GET['page'])?abs((int) trim($_GET['page'])):1;

echo json_encode($rec->getPage($page));
