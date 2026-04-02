<?php 

    //generate code
    function generate_code(){
        return uniqid();
    }

    //get JSON file path
    function get_data_users_JSON_path(){
        $file = __DIR__ . "/../../model/json/data_users.json";
        return $file;
    }
    function get_data_workout_JSON_path(){
        $file = __DIR__ . "/../../model/json/workout_users.json";
        return $file;
    }

    //verifying if JSON file exists
    function verify_if_JSON_file_exists($file, $new_data){
        if(!file_exists($file) || filesize($file) == 0 || json_decode(file_get_contents($file)) === null){
            if($new_data === null){
                $data_to_save = [];
            }else{
                $data_to_save = array($new_data);
            }
            $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents($file, $encoded_data, LOCK_EX);
            return "true";
        }else{
            return "false";
        }
    }
?>