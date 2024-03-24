<?php 

require "classes.php";

if(!isset($_POST['lat'])  or !isset($_POST['lng']) ){
    die('{"res":0, "exp":"Coordinate data error!"}');
}

$file_cls=new coord_handle();

$lat= (float) $_POST['lat'];
$lng= (float) $_POST['lng'];

$file_cls->get_coord($lat, $lng);

if(!$file_cls->validate_coord()){
    die('{"res":0, "exp":"Coordinate data error!"}');
}

if($file_cls->save_coord()){
    die('{"res":1, "exp":"Point has been saved..."}');
}

die('{"res":0, "exp":"An Error Occured..."}');

?>