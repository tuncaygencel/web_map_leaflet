<?php 

require "classes.php";

if(!isset($_POST['id']) ){
    die('{"res":0, "exp":"Error! Point could not found"}');
}

$file_cls=new coord_handle();

$id= (int) $_POST['id'];

$file_cls->get_coord(0,0, $id);

if($file_cls->delete_point()){
    die('{"res":1, "exp":"Point has been deleted..."}');
}

die('{"res":0, "exp":"An Error Occured..."}');

?>