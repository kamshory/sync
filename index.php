<?php
require_once dirname(__FILE__) . "/lib.inc/functions.php";
require_once dirname(__FILE__) . "/lib.inc/sync.php";
//require_once(dirname(__FILE__) . "/lib.inc/sign-in.php");

$pageTitle = "Halaman Depan";
require_once(dirname(__FILE__) . "/lib.inc/header.php");
?>

      <canvas class="my-4 w-100" id="sync-chart" width="900" height="380"></canvas>

<?php
$dataDatabase = array();
$dataFile = array();
$labels = array();
$dataDatabaseOk = array();
$dataFileOk = array();

$start_date = date('Y-m-d H:i:s', strtotime("-2 months"));

$sql1 = "SELECT * FROM `edu_sync_database` WHERE `time_create` > '$start_date' ORDER BY `time_create` ASC";
$stmt1 = $database->executeQuery($sql1);
$rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM `edu_sync_file` WHERE `time_create` > '$start_date' ORDER BY `time_create` ASC";
$stmt2 = $database->executeQuery($sql2);
$rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$now = time();
$min = $now;
$max = $now;

if(!empty($rows1) && $min > strtotime($rows1[0]['time_create']))
{
    $min = strtotime($rows1[0]['time_create']);
}
if(!empty($rows2) && $min > strtotime($rows2[0]['time_create']))
{
    $min = strtotime($rows2[0]['time_create']);
}

for($i = $min; $i<=$max; $i+=86400)
{
  $key = date("Y-m-d 00:00:00", $i);
  $key = strtotime($key);
  $dataDatabase[$key] = 0;
  $dataFile[$key] = 0;
}

foreach($rows1 as $k=>$v)
{
    $key = date("Y-m-d 00:00:00", strtotime($v['time_create']));
    $key = strtotime($key);
    if(!isset($dataDatabase[$key]))
    {
        $dataDatabase[$key] = 0;
    }
    $dataDatabase[$key]++;
}

foreach($rows2 as $k=>$v)
{
    $key = date("Y-m-d 00:00:00", strtotime($v['time_create']));
    $key = strtotime($key);
    if(!isset($dataFile[$key]))
    {
        $dataFile[$key] = 0;
    }
    $dataFile[$key]++;
}

$keys = array_merge(array_keys($dataDatabase), array_keys($dataFile));
$keys = array_unique($keys);
sort($keys);

foreach($keys as $v)
{
    $labels[] = date('d M', $v);
}


?>
<script>
    let dataDatabase = <?php echo json_encode(array_values($dataDatabase));?>;
    let dataFile = <?php echo json_encode(array_values($dataFile));?>;
    let labels = <?php echo json_encode($labels);?>;
</script>
<script src="lib.assets/dashboard/Chart.min.js"></script>
<script src="lib.assets/dashboard/dashboard.js"></script>
<?php
require_once(dirname(__FILE__) . "/lib.inc/footer.php");
?>