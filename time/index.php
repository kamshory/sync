<?php
require_once(dirname(dirname(__FILE__)) . "/lib.inc/functions.php");
require_once(dirname(dirname(dirname(__FILE__)))."/lib.inc/vendor/autoload.php");
use phpseclib3\Net\SFTP;
$sftp = new SFTP('localhost', 22, 30);

if (!empty(@$_GET['time'])) {
    $time = trim($_GET['time']);
    $timeZone = trim($_GET['time_zone']);
    date_default_timezone_set($timeZone);

    $sftp->login('root', 'pass');

    $commands = array();


    // Set time zone and date time
    $commands[] = "/bin/timedatectl set-timezone " . $timeZone;
    $commands[] = "rm -rf /etc/localtime";
    $commands[] = "ln -s /usr/share/zoneinfo/" . $timeZone . " /etc/localtime";
    $commands[] = "/bin/hwclock --set --date \"".date("m/d/Y H:i:s", $time)."\"";

    $sftp->exec(implode(";", $commands));

    $result = array(
        'response_code' => '00',
        'response_text' => 'Sukses',
        'data' => $rows
    );

    header('Content-type: application/json'); //NOSONAR
    echo json_encode($result, JSON_PRETTY_PRINT);
}