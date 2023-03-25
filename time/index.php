<?php
require_once dirname(dirname(__FILE__)) . "/lib.inc/functions.php";
require_once dirname(dirname(__FILE__)) . "/lib.inc/vendor/autoload.php";

use phpseclib3\Net\SFTP;
use phpseclib3\Exception\UnableToConnectException;

$result = new \stdClass;

if (!empty(@$_POST['time']) && !empty(@$_POST['timezone'])) {
    try {
        $time = trim($_POST['time']);
        $timeZone = trim($_POST['timezone']);
        date_default_timezone_set($timeZone);


        $iniPath = dirname(dirname(__DIR__)) . "/sftp.ini";
        $sftpConfig = parse_ini_file($iniPath);
        $sftp = new SFTP($sftpConfig['host'], $sftpConfig['port'], $sftpConfig['timeout']);
        $sftp->login($sftpConfig['username'], $sftpConfig['password']);


        $commands = array();

        // Set time zone and date time via timedatectl
        $commands[] = "/bin/timedatectl set-ntp false ";
        $commands[] = "/bin/timedatectl set-timezone " . $timeZone;
        $commands[] = "/bin/timedatectl set-time '" . date("Y-m-d H:i:s", $time) . "'";

        // Set date time to rtc module via hwclock
        $commands[] = "/bin/hwclock --set --date \"" . date("m/d/Y H:i:s", $time) . "\"";

        $sftp->exec(implode(";", $commands));

        $result = array(
            'response_code' => '00',
            'response_text' => 'Sukses',
            'data' => null
        );

        $phpIni = new \Sync\PHPConfig(dirname(dirname(__FILE__)) . "/php.ini");
        $data = array('date.timezone' => $timeZone);
        $phpIni->update($data);
    } catch (UnableToConnectException $e) {
        $result = array(
            'response_code' => '03',
            'response_text' => 'Gagal',
            'data' => null
        );
    }

    header('Content-type: application/json'); //NOSONAR
    echo json_encode($result, JSON_PRETTY_PRINT);
}
