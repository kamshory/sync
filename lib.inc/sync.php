<?php
$auth = false;

$headers = getallheaders();
if(!isset($_SERVER['HTTP_AUTHORIZATION']) && isset($headers['Authorization']))
{
    $_SERVER['HTTP_AUTHORIZATION'] = $headers['Authorization'];
}

if(isset($_SERVER['HTTP_AUTHORIZATION']))
{
    $eup = trim(substr($_SERVER['HTTP_AUTHORIZATION'], 6));
    $up = base64_decode($eup);
    $auth = null;
    if(stripos($up, ":") !== false)
    {
        list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , $up);
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $auth = new \Sync\UserAuth($database, $username, $password);
        $auth->login();
    }

    if(!$auth->isSuccess())
    {
        $result = array(
            'response_code' => '09',
            'response_text' => 'Pengguna tidak terdaftar'
        );

        header('Content-type: application/json'); //NOSONAR
        echo json_encode($result, JSON_PRETTY_PRINT);
        exit();
    }

    if(@$_GET['action'] == 'ping')
    {
        $result = array(
            'response_code' => '00',
            'response_text' => 'Success'
        );

        header('Content-type: application/json'); //NOSONAR
        echo json_encode($result, JSON_PRETTY_PRINT);
        exit();
    }
    
    if(@$_GET['sync_type'] == 'time')
    {
        require_once dirname(dirname(__FILE__)) . "/time/index.php";
        exit();
    }
    if(@$_GET['sync_type'] == 'file')
    {
        require_once dirname(dirname(__FILE__)) . "/file/index.php";
        exit();
    }
    if(@$_GET['sync_type'] == 'database')
    {
        require_once dirname(dirname(__FILE__)) . "/database/index.php";
        exit();
    }
}