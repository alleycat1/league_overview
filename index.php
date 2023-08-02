<?php
session_start();
error_reporting(E_ALL);
// error_reporting(0);

$API_calls = 0;

// Top leagues
$top_leagues = [
    // [1, "World Cup"],
   
    [39, "Premier League"],
    [140, "La Liga"],
    [135, "Serie A"],
    [78, "Bundesliga"],
    [61, "Ligue 1"],
    [88, "Eredivisie"],
    [94, "Primeira Liga"],
    [2, "UEFA CL"],
    [3, "UEFA EL"],
    [848, "UEFA ECL"],
    [45, "FA Cup"],
    [41, "League 1"],
    [203, "Süper Lig"],
    [113, "Allsvenskan"],
    [114, "Superettan"],
     [960, "Euro Championship Qualifying"]
];

// classes
foreach(glob('./files/classes/*.php') as $class) require $class;

// live update
if(isset($_GET['live_update']) && isset($_POST['endpoint'])) {
    $endpoint = $_POST['endpoint'];
    $data = $config->query($endpoint);
    $sorted = $config->sort_leagues($data);
   //  $fixtures = $config->leagues(json_encode($sorted[0]));//poss remove
    $a = $sorted[0]['response'];
    $b = $sorted[1]['response'];
    $merge = array_merge($a, $b);
    $return = array(
        "get" => $sorted[0]['get'],
        "parameters" => $sorted[0]['parameters'],
        "errors" => $sorted[0]['errors'],
        "results" => $sorted[0]['results'],
        "paging" => $sorted[0]['paging'],
        "response" => $merge
    );
    echo json_encode($return);
    exit;
}

// vectors
$dir = './files/assets/vectors';
$svg = array();
foreach (glob("$dir/*.svg") as $file) {
    $ph = pathinfo($file);
    // echo $ph;
    $svg[$ph['filename']] = file_get_contents($file);
}
foreach (glob("$dir/v/*.svg") as $file) {
    $ph = pathinfo($file);
    // echo $ph;
    $svg[$ph['filename']] = file_get_contents($file);
}

// require './files/webhits.php';
// assets conditional rendering
$async = isset($_POST['async']) ? 1 : 0;
require './files/seo.php';
if(!$async) require './files/header.php';

// navigation
chdir('./files/navigation');
$module = isset($_GET['mod']) && file_exists($_GET['mod']) ? $_GET['mode'] : 'football';
$ref = isset($_GET['ref']) && file_exists("$module/".$_GET['ref'].'.php') ? $_GET['ref'] : 'home';

require '../nav.php';
require "$module/$ref.php";

chdir('../../'); // return to the root directory
if(!$async) require './files/footer.php';
