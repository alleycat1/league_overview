<?php
function str_ord(string $string = '') {
    $str_array = str_split($string);
    $return_string = '';
    foreach($str_array as $key => $char) {
        $return_string .= ord($char);
        if($key < count($str_array)-1) $return_string .= "-";
    }
    return $return_string;
}

if(!file_exists("dates")) mkdir("dates");

$today = str_ord(date('Y-m-d'));
$file = "dates/$today.txt";
$file2 = "dates/$today.hits.txt";
if(!file_exists($file)) file_put_contents($file, "0");
if(!file_exists($file2)) file_put_contents($file2, "0");

$fileHandle = fopen($file, "a+");         
$content = fread($fileHandle, filesize($file));
$content_array = explode('-', $content);

$fileHandle2 = fopen($file2, "a+");         
$content2 = fread($fileHandle2, filesize($file2));
$content_array2 = explode('-', $content2);

if(!isset($_COOKIE['present'])){
    $cookieValue = $content_array[count($content_array)-1]+1;
    $content_array[] = $cookieValue;
    fwrite($fileHandle, "-$cookieValue");
    setcookie('present',$cookieValue, time() + 3600*24);
}
fwrite($fileHandle2, "-" . $content_array2[count($content_array2)-1]+1);

fclose($fileHandle);
fclose($fileHandle2);