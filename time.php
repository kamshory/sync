<?php
require_once(dirname(__FILE__) . "/lib.inc/autoload.php");
(new \Sync\PHPConfig(dirname(__FILE__)."/php.ini"))->loadAndApply();
echo date('Y-m-d H:i:s')."<br>";

$conf = new \Sync\PHPConfig(dirname(__FILE__)."/php.ini");

$data = array(
    'content_type'=>'application/json'
);
$conf->update($data);

# define_syslog_variables=Off
echo ini_get('date.timezone');