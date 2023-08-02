<?php
// print_r(glob('*'));
set_time_limit(0);

require './classes/class.config.php';
require './classes/class.thumbs.php';

$data = json_decode($config->query('leagues'),1);
$response = $data['response'];
$leagues = [];
foreach($response as $league) {
    try {
        $leagues[] = array(
            'league' => $league['league']['name'],
            'logo' => $league['league']['logo'],
        );
        
        $image = $league['league']['logo'];
        $info = pathinfo($image);
        $existing_image = "./assets/league/logos/o-".$info['basename'];
        $thumb = "./assets/league/logos/".$info['basename'];
        
        if(file_exists($existing_image)) continue;
        // download the image to server
        $image_content = file_get_contents($image);
        $f = fopen($existing_image, "w");
        fwrite($f, $image_content);
        fclose($f);

        // list($width, $height) = getimagesize($existing_image);

        // $factor = $width / 30;
        // $newHeight = $height / $factor;

        // $config->getImageResized($existing_image, 30, $newHeight);
        
        $thumb = new Thumb_generator($existing_image, $thumb, 30);
        unlink($existing_image);
    } catch (\Throwable $th) {
        echo "Failed to create thumbnail.<br>";
    }
    

}
// echo '<pre>';
// print_r($leagues);
// echo '</pre>';
