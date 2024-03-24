<?php

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
//error_reporting(E_ALL);


class coord_handle {
    
    private $id;
    private $lat;
    private $lng;
    private $json;
    static private $full_file_path='data/coord_file.json';

    public function get_coord($lat, $lng, $id=0 ){

        $this->id=$id;
        $this->lat=number_format($lat,6);
        $this->lng=number_format($lng,6);

    }

    public function validate_coord(){

        if($this->lat >= -90 and $this->lat <= 90 and $this->lng >= -180 and $this->lng <= 180){
            return true;
        }

        return false;

    }


    private function read_file(){
        
        //if file does not exist create one
        if (!file_exists(self::$full_file_path)) {
            touch(self::$full_file_path);
        }

        $fh = file_get_contents(self::$full_file_path, FILE_USE_INCLUDE_PATH);
        
        $this->json = json_decode($fh,true);

        return true;

    }

    private function save_file(){

        $file = fopen(self::$full_file_path, "w");

        fwrite($file, json_encode($this->json));
        
        fclose($file);
        
        return true;
    
    }

    public function find_next_id(){

        $last_id=0;

        if(is_array($this->json)){
            if(isset(end($this->json)["id"])){
                $last_id=((int)end($this->json)["id"]);
            }
        }

        $this->id=$last_id+1;
        
        return true;
        
    }


    public function save_coord(){

        self::read_file();
        
        self::find_next_id();

        $arr_row=["id" => $this->id, "lat" => $this->lat, "lng" => $this->lng, "datetime" => date("Y-m-d H:i:s")];

        if(is_array($this->json)){
            array_push($this->json, $arr_row);
        }else{
            $this->json=[$arr_row];
        }
        
        return self::save_file();

    }

    public function read_all(){

        self::read_file();

        return $this->json;

    }

    public function delete_point(){

        self::read_file();
        
        $index=0;

        foreach ($this->json as $p) {
            
            if($p["id"]==$this->id){
                unset($this->json[$index]);
            }

            $index+=1;

        }

        $this->json=array_values($this->json);

        return self::save_file();

    }


}
?>