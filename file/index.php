<?php
require_once(dirname(dirname(__FILE__)) . "/lib.inc/functions.php");

if (@$_GET['action'] == 'list-record') {
    $application_id = addslashes(trim($_GET['application_id']));
    $last_sync = trim(@$_GET['last_sync']);
    $last_sync = addslashes($last_sync);
    $filter = "";
    if(!empty($last_sync))
    {
        $filter .= " AND `time_create` > '$last_sync' ";
    }
    if(!empty($application_id))
    {
        $filter .= " AND `application_id` = '$application_id' ";
    }
    $rows = $database
        ->executeQuery("SELECT * from `edu_sync_file` WHERE 1 $filter ORDER BY `time_create` ASC ")
        ->fetchAll(PDO::FETCH_ASSOC);

    $result = array(
        'response_code' => '00',
        'response_text' => 'Sukses',
        'data' => $rows
    );

    header('Content-type: application/json'); //NOSONAR
    echo json_encode($result, JSON_PRETTY_PRINT);
}
if (@$_GET['action'] == 'upload-sync-file') {

    $application_id = addslashes(trim($_POST['application_id']));
    $sync_file_id = addslashes(trim($_POST['sync_file_id']));
    $file_path = addslashes(trim($_POST['file_path']));
    $relative_path = addslashes(trim($_POST['relative_path']));
    $file_name = addslashes(trim($_POST['file_name']));
    $file_size = (int) (trim($_POST['file_size']));
    $time_create = addslashes(trim($_POST['time_create']));
    $time_upload = addslashes(trim($_POST['time_upload']));
    
    $sql = "INSERT INTO `edu_sync_file` 
    (`sync_file_id`, `file_path`, `relative_path`, `file_name`, `file_size`, `time_create`, `time_upload`, `time_download`, `time_sync`, `status`) VALUES
    ('$sync_file_id', '$file_path', '$relative_path', '$file_name', '$file_size', '$time_create', '$time_upload', NULL, NULL, 0)
    ";

    $fileUpload->upload($_POST['relative_path'], $_FILES['file_contents']);
    $database->execute($sql);
    $result = array(
        'response_code' => '00',
        'response_text' => 'Sukses'
    );
    header('Content-type: application/json'); //NOSONAR
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit();
}

if (@$_GET['action'] == 'upload-user-file') {
    $application_id = addslashes(trim($_POST['application_id']));
    $fileUpload->upload($_POST['relative_path'], $_FILES['file_contents']);
    $result = array(
        'response_code' => '00',
        'response_text' => 'Sukses'
    );
    header('Content-type: application/json'); //NOSONAR
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit();
}
