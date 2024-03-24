<?php 

    require "classes.php";

    $file_cls=new coord_handle();

    $data=$file_cls->read_all();

    echo json_encode($data);

?>